<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\rangkuman_firman;
use Illuminate\Support\Facades\Auth;

class RangkumanFirmanController extends Controller
{
    public function viewall(): View
    {
        return view(
            'RangkumanFirman.viewall',
            [
                'title' => 'Halaman Rangkuman Firman',
                'rangkuman' => rangkuman_firman::latest('tgl_rangkuman')->paginate(5),
            ]
        );
    }
    public function tambah(): View
    {
        return view(
            'RangkumanFirman.tambah',
            [
                'title' => 'Tambah Rangkuman Firman',
                'id_rangkuman' => rangkuman_firman::generateNextId(),
            ]
        );
    }
    public function ubah(rangkuman_firman $rangkuman): View
    {
        return view(
            'RangkumanFirman.ubah',
            [
                'title' => 'Ubah Rangkuman Firman',
                'rangkuman' => $rangkuman,
            ]
        );
    }

    public function add(Request $request)
    {
        $rangkuman = new rangkuman_firman();
        $rangkuman->id_rangkuman_firman = rangkuman_firman::generateNextId();
        //TODO ubah ini kalo udah bisa authorization
        $rangkuman->id_pelayan_pnl = 'PL180903A1';
        $rangkuman->nama_narasumber = $request->nama_narasumber;
        $rangkuman->judul_rangkuman = $request->judul_rangkuman;
        $rangkuman->slug_rangkuman = Str::slug($request->judul_rangkuman);
        $rangkuman->tipe_rangkuman = $request->tipe_rangkuman;
        $rangkuman->kategori_sermons = $request->kategori_sermons;
        $rangkuman->tgl_rangkuman = now();
        // $rangkuman->gambar_rangkuman = $request->gambar_rangkuman;
        $rangkuman->isi_rangkuman = $request->isi_rangkuman;

        if ($request->hasFile('gambar_rangkuman')) {
            $file = $request->file('gambar_rangkuman');
            $originalName = $file->getClientOriginalName();
            $targetDir = 'gambarRangkuman';

            // Prevent filename collisions by prefixing with a timestamp if file exists
            $storagePath = storage_path("app/public/{$targetDir}/{$originalName}");
            if (file_exists($storagePath)) {
                $filenameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $originalName = $filenameWithoutExt . '_' . time() . '.' . $extension;
            }

            // Store the file with its (possibly modified) original name
            $path = $file->storeAs($targetDir, $originalName, 'public');
            $rangkuman->gambar_rangkuman = $path; // Save the relative path as a string
        }

        $rangkuman->save();

        Riwayat::logChange(1, $request->id_rangkuman, Auth::user()->jemaat->pelayan->id_pelayan);
        return redirect()->route('RangkumanFirman.viewall');
    }
    public function update(Request $request, rangkuman_firman $rangkuman)
    {

        //TODO ubah ini kalo udah bisa authorization
        $kategori_sermons = $request->input('kategori_sermons');
        if ($request->input('tipe_rangkuman') != 'Sermons') {
            $kategori_sermons = null;
        };
        $rangkuman->update([
            'id_pelayan_pnl' => 'PL180903A1',
            'nama_narasumber' => $request->input('nama_narasumber'),
            'judul_rangkuman' => $request->input('judul_rangkuman'),
            'slug_rangkuman' => Str::slug($request->input('judul_rangkuman')),
            'tipe_rangkuman' => $request->input('tipe_rangkuman'),
            'kategori_sermons' => $kategori_sermons,
            'isi_rangkuman' => $request->input('isi_rangkuman'),
        ]);
        // $rangkuman->gambar_rangkuman = $request->gambar_rangkuman;

        if ($request->hasFile('gambar_rangkuman')) {
            $file = $request->file('gambar_rangkuman');
            $originalName = $file->getClientOriginalName();
            $targetDir = 'gambarRangkuman';

            // Prevent filename collisions by prefixing with a timestamp if file exists
            $storagePath = storage_path("app/public/{$targetDir}/{$originalName}");
            if (file_exists($storagePath)) {
                $filenameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $originalName = $filenameWithoutExt . '_' . time() . '.' . $extension;
            }

            // Store the file with its (possibly modified) original name
            $path = $file->storeAs($targetDir, $originalName, 'public');
            $rangkuman->update(['gambar_rangkuman' => $path]); // Update the relative path as a string
        }

        Riwayat::logChange(2, $request->id_rangkuman, Auth::user()->jemaat->pelayan->id_pelayan);
        return redirect()->route('RangkumanFirman.viewall');
    }
}
