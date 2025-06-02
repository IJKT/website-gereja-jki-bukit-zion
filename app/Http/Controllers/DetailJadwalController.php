<?php

namespace App\Http\Controllers;

use App\Models\detail_jadwal;
use App\Models\jadwal_ibadah;
use Illuminate\View\View;
use Illuminate\Http\Request;

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
    // public function ubah(jadwal_ibadah $jadwal): View
    // {
    //     return view(
    //         'Jadwal.ubah',
    //         [
    //             'title' => 'ubah Jadwal Ibadah',
    //             'jadwal' => $jadwal
    //         ]
    //     );
    // }
    // public function tambah(): View
    // {
    //     $id_jadwal = jadwal_ibadah::generateNextId();
    //     return view(
    //         'Jadwal.tambah',
    //         [
    //             'title' => 'Tambah Jadwal Ibadah',
    //             'id_jadwal' => $id_jadwal
    //         ]
    //     );
    // }
}
