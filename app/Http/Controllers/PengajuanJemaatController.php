<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use Illuminate\View\View;
use App\Models\Pernikahan;
use Illuminate\Http\Request;
use App\Models\PengajuanJemaat;

class PengajuanJemaatController extends Controller
{
    public function baptis(): View
    {
        // TODO: kerjain ini kalo uda bisa authorization
        $data_baptis = PengajuanJemaat::where('id_jemaat', 'JM180903A1')->where('jenis_pengajuan', 'Baptis')->first();
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
        $data_pernikahan = PengajuanJemaat::where('id_jemaat', 'JM180903A1')->where('jenis_pengajuan', 'Pernikahan')->first();

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
