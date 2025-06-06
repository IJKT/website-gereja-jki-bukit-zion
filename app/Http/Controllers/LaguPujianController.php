<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\View\View;
use App\Models\lagu_pujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaguPujianController extends Controller
{
    public function viewall(): View
    {
        return view(
            'LaguPujian.viewall',
            [
                'title' => 'Halaman Daftar Lagu',
                'lagu' => lagu_pujian::query()->paginate(5)
            ]
        );
    }
    public function tambah(): View
    {
        return view(
            'LaguPujian.tambah',
            [
                'title' => 'Halaman Daftar Lagu',
                'id_lagu' => lagu_pujian::generateNextId(),
            ]
        );
    }
    public function ubah(lagu_pujian $lagu): View
    {
        return view(
            'LaguPujian.ubah',
            [
                'title' => 'Halaman Daftar Lagu',
                'lagu' => $lagu,
            ]
        );
    }



    // PUT FUNCTION
    public function add(Request $request)
    {
        // dd($request->all());

        $lagu = new lagu_pujian();
        $lagu->id_lagu = $request->id_lagu;
        $lagu->nama_lagu = $request->nama_lagu;
        $lagu->link_lagu = $request->link_lagu;
        $lagu->save();

        Riwayat::logChange(1, $request->id_lagu, Auth::user()->jemaat->pelayan->id_pelayan);
        return redirect()->route('LaguPujian.viewall');
    }
    public function update(Request $request, lagu_pujian $lagu)
    {
        // dd($request->all());

        $lagu->update([
            'nama_lagu' => $request->nama_lagu,
            'link_lagu' => $request->link_lagu
        ]);

        Riwayat::logChange(1, $request->id_lagu, Auth::user()->jemaat->pelayan->id_pelayan);
        return redirect()->route('LaguPujian.viewall');
    }
}
