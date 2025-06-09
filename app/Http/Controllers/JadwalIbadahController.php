<?php

namespace App\Http\Controllers;

use App\Models\Pelayan;
use App\Models\Riwayat;
use Illuminate\View\View;
use App\Models\lagu_pujian;
use Illuminate\Http\Request;
use App\Models\detail_jadwal;
use App\Models\jadwal_ibadah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class JadwalIbadahController extends Controller
{
    // GET FUNCTIONS
    public function viewall(): View
    {
        return view(
            'Jadwal.viewall',
            [
                'title' => 'Halaman Jadwal Ibadah',
                'jadwal' => jadwal_ibadah::query()->paginate(5)
            ]
        );
    }
    public function ubah(jadwal_ibadah $jadwal): View
    {
        return view(
            'Jadwal.ubah',
            [
                'title' => 'ubah Jadwal Ibadah',
                'jadwal' => $jadwal,
                'pendeta' => (clone $jadwal)->detail_jadwal->where('peran_pelayan', 1)->first()
            ]
        );
    }
    public function tambah(): View
    {
        $id_jadwal = jadwal_ibadah::generateNextId();
        return view(
            'Jadwal.tambah',
            [
                'title' => 'Tambah Jadwal Ibadah',
                'id_jadwal' => $id_jadwal
            ]
        );
    }

    // PUT FUNCTIONS
    public function update(Request $request, jadwal_ibadah $jadwal)
    {
        // dd(detail_jadwal::where('id_jadwal', $jadwal->id_jadwal)->where('peran_pelayan', 1)->first());

        // Make backtrack optional
        $request->validate([
            'jenis_ibadah' => 'required',
            'tgl_ibadah' => 'required|date',
            'backtrack' => 'nullable|file|mimes:mp3',
        ]);

        // Update the jadwal record
        $jadwal->jenis_ibadah = $request->jenis_ibadah;
        $jadwal->tgl_ibadah = $request->tgl_ibadah;

        if ($request->hasFile('backtrack')) {
            $file = $request->file('backtrack');
            $originalName = $file->getClientOriginalName();
            $targetDir = 'backtracks';

            // Prevent filename collisions by prefixing with a timestamp if file exists
            $storagePath = storage_path("app/public/{$targetDir}/{$originalName}");
            if (file_exists($storagePath)) {
                $filenameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $originalName = $filenameWithoutExt . '_' . time() . '.' . $extension;
            }

            // Store the file with its (possibly modified) original name
            $path = $file->storeAs($targetDir, $originalName, 'public');
            $jadwal->backtrack = $path;
        }

        $jadwal->save();

        //update pendeta
        detail_jadwal::where('id_jadwal', $jadwal->id_jadwal)
            ->where('peran_pelayan', 1)
            ->update([
                'id_pelayan' => $request->filled('id_pelayan') ? $request->id_pelayan : null,
                'nama_pendeta_undangan' => $request->filled('id_pelayan') ? null : $request->nama_pendeta
            ]);
        Riwayat::logChange(2, $jadwal->id_jadwal, Auth::user()->jemaat->pelayan->id_pelayan);

        // Redirect back with a success message
        return redirect()->route('Jadwal.viewall');
    }
    public function add(Request $request)
    {
        // Validate input (optional but recommended)

        $request->validate([
            'jenis_ibadah' => 'required',
            'id_jadwal' => 'required',
            'tgl_ibadah' => 'required|date',
            'backtrack' => 'nullable|file|mimes:mp3',
        ]);

        $new_id = jadwal_ibadah::generateNextId();
        $jadwal = new jadwal_ibadah();
        $jadwal->jenis_ibadah = $request->jenis_ibadah;
        $jadwal->id_jadwal = $new_id;
        $jadwal->tgl_ibadah = $request->tgl_ibadah;

        if ($request->hasFile('backtrack')) {
            $file = $request->file('backtrack');
            $originalName = $file->getClientOriginalName();
            $targetDir = 'backtracks';

            // Prevent filename collisions by prefixing with a timestamp if file exists
            $storagePath = storage_path("app/public/{$targetDir}/{$originalName}");
            if (file_exists($storagePath)) {
                $filenameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $originalName = $filenameWithoutExt . '_' . time() . '.' . $extension;
            }

            // Store the file with its (possibly modified) original name
            $path = $file->storeAs($targetDir, $originalName, 'public');
            $jadwal->backtrack = $path; // Save the relative path as a string
        }

        $jadwal->save();

        detail_jadwal::create([
            'id_jadwal' => $new_id,
            'peran_pelayan' => 1, // 1 = Pendeta
            'id_pelayan' => $request->filled('id_pelayan') ? $request->id_pelayan : null,
            'nama_pendeta_undangan' => $request->filled('id_pelayan') ? null : $request->nama_pendeta
        ]);

        Riwayat::logChange(1, $jadwal->id_jadwal, Auth::user()->jemaat->pelayan->id_pelayan);
        return redirect()->route('Jadwal.viewall');
    }

    public function searchPendeta(Request $request)
    {
        $query = $request->get('q');

        $results = Pelayan::join('jemaat', 'pelayan.id_jemaat', '=', 'jemaat.id_jemaat')
            ->where('jemaat.nama_jemaat', 'like', "%$query%")
            ->select('pelayan.id_pelayan', 'jemaat.nama_jemaat as nama_pendeta')
            ->get();

        return response()->json($results);
    }
    public function searchMultimedia(Request $request)
    {
        $query = $request->get('q');
        $jadwalId = $request->get('jadwal_id');

        // Default to empty collection if no jadwal_id
        $excludedPelayanIds = collect();

        if ($jadwalId) {
            $excludedPelayanIds = DB::table('detail_jadwal')
                ->where('id_jadwal', $jadwalId)
                ->pluck('id_pelayan');
        }

        $results = Pelayan::join('jemaat', 'pelayan.id_jemaat', '=', 'jemaat.id_jemaat')
            ->where('jemaat.nama_jemaat', 'like', "%$query%")
            ->where('pelayan.hak_akses_pelayan', 'Multimedia')
            ->whereNotIn('pelayan.id_pelayan', $excludedPelayanIds)
            ->select('pelayan.id_pelayan', 'jemaat.nama_jemaat as nama_pelayan')
            ->get();

        return response()->json($results);
    }
    public function searchMusik(Request $request)
    {
        $query = $request->get('q');
        $jadwalId = $request->get('jadwal_id');

        // Default to empty collection if no jadwal_id
        $excludedPelayanIds = collect();

        if ($jadwalId) {
            $excludedPelayanIds = DB::table('detail_jadwal')
                ->where('id_jadwal', $jadwalId)
                ->pluck('id_pelayan');
        }

        $results = Pelayan::join('jemaat', 'pelayan.id_jemaat', '=', 'jemaat.id_jemaat')
            ->where('jemaat.nama_jemaat', 'like', "%$query%")
            ->where('pelayan.hak_akses_pelayan', 'Praise & Worship')
            ->whereNotIn('pelayan.id_pelayan', $excludedPelayanIds)
            ->select('pelayan.id_pelayan', 'jemaat.nama_jemaat as nama_pelayan')
            ->get();

        return response()->json($results);
    }
    public function searchPujian(Request $request)
    {
        $query = $request->get('q');
        $jadwalId = $request->get('jadwal_id');

        // Default to empty collection if no jadwal_id
        $excludedPujianIds = collect();

        if ($jadwalId) {
            $excludedPujianIds = DB::table('detail_lagu_pujian')
                ->where('id_jadwal', $jadwalId)
                ->pluck('id_lagu');
        }
        $results = lagu_pujian::where('nama_lagu', 'like', "%$query%")
            ->whereNotIn('id_lagu', $excludedPujianIds)
            ->select('id_lagu', 'nama_lagu')
            ->get();

        return response()->json($results);
    }
}
