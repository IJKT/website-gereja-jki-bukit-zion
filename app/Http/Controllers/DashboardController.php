<?php

namespace App\Http\Controllers;

use App\Models\detail_jadwal;
use App\Models\Jemaat;
use App\Models\Kontak;
use App\Models\Pelayan;
use App\Models\Pembukuan;
use App\Models\PengajuanJemaat;
use App\Models\rangkuman_firman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $jadwal = null;
        if (Auth::user()->jemaat->hak_akses_jemaat != 'Jemaat') {
            $jadwal = detail_jadwal::where('id_pelayan', Auth::user()->jemaat->pelayan->id_pelayan)
                ->whereHas('jadwal_ibadah', function ($query) {
                    $query->where('tgl_ibadah', '>', now());
                })
                ->paginate(3);
        }

        return view('Dashboard.dashboard', [
            'title' => "Halaman Dashboard",
            'jemaat' => Jemaat::where('status_jemaat', 1)->get(),
            'pelayan' => Pelayan::where('status_pelayan', 1)->get(),
            'pembukuan' => Pembukuan::where('verifikasi_pembukuan', 0)->get(),
            'kontak' => Kontak::where('status', 0)->get(),
            'pengajuan_jemaat' => PengajuanJemaat::where('verifikasi_pengajuan', 0)->get(),
            'rangkuman_firman' => rangkuman_firman::OrderBy('id_rangkuman_firman', 'desc')->limit(3)->get(),
            'jadwal' => $jadwal,
        ]);
    }
}
