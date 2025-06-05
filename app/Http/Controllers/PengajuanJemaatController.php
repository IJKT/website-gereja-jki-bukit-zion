<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use Illuminate\View\View;
use App\Models\Pernikahan;
use Illuminate\Http\Request;
use App\Models\PengajuanJemaat;
use Illuminate\Support\Facades\Auth;

class PengajuanJemaatController extends Controller
{
    public function baptis(): View
    {
        // TODO: kerjain ini kalo uda bisa authorization
        $data_baptis = PengajuanJemaat::where('id_jemaat', Auth::user()->jemaat->id_jemaat)->where('jenis_pengajuan', 'Baptis')->first();

        if (!$data_baptis) {
            return view('PengajuanJemaat.baptis', [
                'title' => "Pengajuan Baptis",
                'data_baptis' => null,
                'detail_baptis' => null,
            ]);
        }

        return view('PengajuanJemaat.baptis', [
            'title' => "Pengajuan Baptis",
            'data_baptis' => $data_baptis,
            'detail_baptis' => Baptis::where('id_baptis', $data_baptis->id_pengajuan)->first()
        ]);
    }
    public function add_baptis(): View
    {
        // TODO: kerjain ini kalo uda bisa authorization
        $data_baptis = PengajuanJemaat::where('id_jemaat', Auth::user()->jemaat->id_jemaat)->where('jenis_pengajuan', 'Baptis')->first();
        return view(
            'PengajuanJemaat.baptis',
            [
                'title' => "Pengajuan Baptis",
                'data_baptis' => $data_baptis,
                'detail_baptis' => Baptis::where('id_baptis', $data_baptis->id_pengajuan)->first()
            ]
        );
    }
    public function pernikahan(): View
    {
        // TODO: kerjain ini kalo uda bisa authorization
        $data_pernikahan = PengajuanJemaat::where('id_jemaat', Auth::user()->jemaat->id_jemaat)->where('jenis_pengajuan', 'Pernikahan')->first();
        if (!$data_pernikahan) {
            return view('PengajuanJemaat.pernikahan', [
                'title' => "Pengajuan Pernikahan",
                'data_pernikahan' => null,
                'detail_pernikahan' => null,
            ]);
        }
        return view(
            'PengajuanJemaat.pernikahan',
            [
                'title' => "Pengajuan Pernikahan",
                'data_pernikahan' => $data_pernikahan,
                'detail_pernikahan' => Pernikahan::where('id_pernikahan', $data_pernikahan->id_pengajuan)->first()
            ]
        );
    }
}
