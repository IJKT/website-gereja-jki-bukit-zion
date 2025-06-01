<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\jadwal_ibadah;
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
                'jadwal' => $jadwal
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
        // Update the jadwal record
    }
    public function add(Request $request)
    {
        // Validate input (optional but recommended)
        $request->validate([
            'jenis_ibadah' => 'required',
            'id_jadwal' => 'required',
            'tgl_ibadah' => 'required|date',
            'backtrack' => 'required|file|mimes:mp3',
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
            // Optionally, save the original name for display
            if (Schema::hasColumn('jadwal_ibadah', 'backtrack_original_name')) {
                $jadwal->backtrack_original_name = $file->getClientOriginalName();
            }
        }

        $jadwal->save();
        Riwayat::logChange(1, $jadwal->id_jadwal, null);
        return redirect()->route('Jadwal.viewall');
    }
}
