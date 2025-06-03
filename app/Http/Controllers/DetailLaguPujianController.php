<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use App\Models\lagu_pujian;
use Illuminate\Http\Request;
use App\Models\detail_jadwal;
use App\Models\detail_lagu_pujian;
use App\Models\jadwal_ibadah;

class DetailLaguPujianController extends Controller
{
    public function tambah_pujian(jadwal_ibadah $jadwal)
    {
        session(['second_last_url' => url()->previous()]);

        return view(
            'Jadwal.Detail.tambah_pujian',
            [
                'title' => 'Tambah Data Lagu Pujian',
                'urutan_lagu' => detail_lagu_pujian::where('id_jadwal', $jadwal->id_jadwal)->count() + 1,
                'jadwal' => $jadwal
            ]
        );
    }

    public function ubah_pujian(detail_lagu_pujian $detail_lagu, lagu_pujian $lagu)
    {
        session(['second_last_url' => url()->previous()]);

        $data_lagu = $detail_lagu::where('id_lagu', $lagu->id_lagu)->first();

        return view(
            'Jadwal.Detail.ubah_pujian',
            [
                'title' => 'Ubah Data Pujian',
                'data_lagu' => $data_lagu, // single pelayan for this assignment
            ]
        );
    }


    public function AddLagu(Request $request)
    {
        $detail_lagu = new detail_lagu_pujian();

        $detail_lagu->id_jadwal = $request->id_jadwal;
        $detail_lagu->id_lagu = $request->id_lagu;
        $detail_lagu->urutan_lagu = $request->urutan_lagu;
        $detail_lagu->save();

        Riwayat::logChange(1, $request->id_jadwal, null);

        $secondLastUrl = $request->input('second_last_url', session('second_last_url', url('/')));
        // Optionally clear it from session
        session()->forget('second_last_url');

        return redirect($secondLastUrl);
    }
    public function UpdateLagu(Request $request)
    {
        // You should pass a unique identifier for the detail_jadwal you want to update.
        detail_lagu_pujian::where('id_lagu', $request->id_lagu)
            ->where('id_jadwal', $request->id_jadwal)
            ->update([
                'urutan_lagu' => $request->urutan_lagu
            ]);

        Riwayat::logChange(2, $request->id_jadwal, null);

        $secondLastUrl = $request->input('second_last_url', session('second_last_url', url('/')));
        // Optionally clear it from session
        session()->forget('second_last_url');

        return redirect($secondLastUrl);
    }
}
