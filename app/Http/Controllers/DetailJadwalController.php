<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\detail_jadwal;
use App\Models\jadwal_ibadah;
use App\Models\detail_lagu_pujian;
use App\Models\Pelayan;

class DetailJadwalController extends Controller
{
    public function viewall_musik(jadwal_ibadah $jadwal): View
    {
        $detailJadwal = detail_jadwal::where('id_jadwal', $jadwal->id_jadwal);
        $pendeta = (clone $detailJadwal)->where('peran_pelayan', 1)->first();
        $pelayan_musik = (clone $detailJadwal)->where('peran_pelayan', '>=', 2)->where('peran_pelayan', '<=', 7)->paginate(5);
        return view(
            'Jadwal.Detail.viewall_musik',
            [
                'title' => 'Halaman Pelayan Musik',
                'pendeta' => $pendeta,
                'pelayan_musik' => $pelayan_musik,
                'jadwal' => $jadwal
            ]
        );
    }
    public function tambah_musik(jadwal_ibadah $jadwal): View
    {
        session(['second_last_url' => url()->previous()]);

        return view(
            'Jadwal.Detail.tambah_musik',
            [
                'title' => 'Tambah Pelayan Praise & Worship',
                'jadwal' => $jadwal
            ]
        );
    }
    public function ubah_musik(detail_jadwal $detail_jadwal, Pelayan $pelayan)
    {
        session(['second_last_url' => url()->previous()]);

        $data_pelayan = $detail_jadwal::with('pelayan')->where('id_pelayan', $pelayan->id_pelayan)->first();

        return view(
            'Jadwal.Detail.ubah_musik',
            [
                'title' => 'Ubah Pelayan Praise & Worship',
                'pelayan' => $data_pelayan, // single pelayan for this assignment
            ]
        );
    }
    public function viewall_multimedia(jadwal_ibadah $jadwal): View
    {
        $detailJadwal = detail_jadwal::where('id_jadwal', $jadwal->id_jadwal);
        $pendeta = (clone $detailJadwal)->where('peran_pelayan', 1)->first();
        $pelayan_multimedia = (clone $detailJadwal)->where('peran_pelayan', '>', 7)->paginate(5);
        return view(
            'Jadwal.Detail.viewall_multimedia',
            [
                'title' => 'Halaman Pelayan Multimedia',
                'pendeta' => $pendeta,
                'pelayan_multimedia' => $pelayan_multimedia,
                'jadwal' => $jadwal
            ]
        );
    }
    public function tambah_multimedia(jadwal_ibadah $jadwal): View
    {
        session(['second_last_url' => url()->previous()]);

        return view(
            'Jadwal.Detail.tambah_multimedia',
            [
                'title' => 'Tambah Pelayan Multimedia',
                'jadwal' => $jadwal
            ]
        );
    }
    public function ubah_multimedia(detail_jadwal $detail_jadwal, Pelayan $pelayan)
    {
        session(['second_last_url' => url()->previous()]);

        $data_pelayan = $detail_jadwal::with('pelayan')->where('id_pelayan', $pelayan->id_pelayan)->first();

        return view(
            'Jadwal.Detail.ubah_multimedia',
            [
                'title' => 'Ubah Pelayan Multimedia',
                'pelayan' => $data_pelayan, // single pelayan for this assignment
            ]
        );
    }
    public function viewall_pujian(jadwal_ibadah $jadwal): View
    {
        $detailJadwal = detail_jadwal::where('id_jadwal', $jadwal->id_jadwal);
        $pendeta = (clone $detailJadwal)->where('peran_pelayan', 1)->first();
        $urutan_lagu = detail_lagu_pujian::where('id_jadwal', $jadwal->id_jadwal)->orderby('urutan_lagu', 'asc')->paginate(5);
        return view(
            'Jadwal.Detail.viewall_pujian',
            [
                'title' => 'Halaman Lagu Pujian',
                'pendeta' => $pendeta,
                'urutan_lagu' => $urutan_lagu,
                'jadwal' => $jadwal
            ]
        );
    }

    public function AddPelayan(Request $request)
    {
        $detail_jadwal = new detail_jadwal();

        $detail_jadwal->id_jadwal = $request->id_jadwal;
        $detail_jadwal->id_pelayan = $request->id_pelayan;
        $detail_jadwal->peran_pelayan = $request->peran_pelayan;
        $detail_jadwal->save();

        Riwayat::logChange(1, $request->id_jadwal, null);

        $secondLastUrl = $request->input('second_last_url', session('second_last_url', url('/')));
        // Optionally clear it from session
        session()->forget('second_last_url');

        return redirect($secondLastUrl);
    }
    public function UpdatePelayan(Request $request)
    {
        // You should pass a unique identifier for the detail_jadwal you want to update.
        detail_jadwal::where('id_pelayan', $request->id_pelayan)
            ->where('id_jadwal', $request->id_jadwal)
            ->update([
                'peran_pelayan' => $request->peran_pelayan
            ]);

        Riwayat::logChange(2, $request->id_jadwal, null);

        $secondLastUrl = $request->input('second_last_url', session('second_last_url', url('/')));
        // Optionally clear it from session
        session()->forget('second_last_url');

        return redirect($secondLastUrl);
    }
}
