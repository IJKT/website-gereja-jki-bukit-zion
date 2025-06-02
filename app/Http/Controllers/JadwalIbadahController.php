<?php

namespace App\Http\Controllers;

use App\Models\Pelayan;
use App\Models\Riwayat;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\jadwal_ibadah;
use Illuminate\Support\Facades\DB;
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

        Riwayat::logChange(2, $jadwal->id_jadwal, null);

        // Redirect back with a success message
        return redirect()->route('Jadwal.viewall')->with('success', 'Jadwal updated successfully!');
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

        $jadwal = new jadwal_ibadah();
        $jadwal->jenis_ibadah = $request->jenis_ibadah;
        $jadwal->id_jadwal = jadwal_ibadah::generateNextId();
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
        Riwayat::logChange(1, $jadwal->id_jadwal, null);
        return redirect()->route('Jadwal.viewall');
    }

    public function searchPendeta(Request $request)
    {
        $query = $request->get('q');

        // Find pelayan with peran_pelayan = 1 (Pendeta), join jemaat for name search
        $results = DB::table('pelayan')
            ->join('jemaat', 'pelayan.id_jemaat', '=', 'jemaat.id_jemaat')
            ->join('detail_jadwal', 'pelayan.id_pelayan', '=', 'detail_jadwal.id_pelayan')
            ->where('detail_jadwal.peran_pelayan', 1)
            ->where('jemaat.nama_jemaat', 'like', "%$query%")
            ->select('pelayan.id_pelayan', 'jemaat.nama_jemaat')
            ->distinct()
            ->get();

        return response()->json($results);
    }
}
