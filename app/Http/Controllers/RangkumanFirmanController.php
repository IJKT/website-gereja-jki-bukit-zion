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
    public function viewall(Request $request): View
    {
        $rangkuman = rangkuman_firman::latest('tgl_rangkuman');

        // Filter by date range if both tanggal_awal and tanggal_akhir are present
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $rangkuman->whereBetween('tgl_rangkuman', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        } elseif ($request->filled('tanggal_awal')) {
            // If only tanggal_awal is present, filter from that date onwards
            $rangkuman->where('tgl_rangkuman', '>=', $request->tanggal_awal);
        } elseif ($request->filled('tanggal_akhir')) {
            // If only tanggal_akhir is present, filter up to that date
            $rangkuman->where('tgl_rangkuman', '<=', $request->tanggal_akhir);
        }

        // Filter by tipe_rangkuman if present and not empty
        if ($request->filled('tipe_rangkuman')) {
            $rangkuman->where('tipe_rangkuman', $request->tipe_rangkuman);
        }

        return view(
            'RangkumanFirman.viewall',
            [
                'title' => 'Halaman Rangkuman Firman',
                'rangkuman' => $rangkuman->paginate(5)->WithQueryString(),
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
        $rangkuman->id_pelayan_pnl = Auth::user()->jemaat->pelayan->id_pelayan;
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

        $kategori_sermons = $request->input('kategori_sermons');
        if ($request->input('tipe_rangkuman') != 'Sermons') {
            $kategori_sermons = null;
        };
        $rangkuman->update([
            'id_pelayan_pnl' => Auth::user()->jemaat->pelayan->id_pelayan,
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
