<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use App\Models\Jemaat;
use App\Models\Pelayan;
use Illuminate\View\View;
use App\Models\Pernikahan;
use Illuminate\Http\Request;
use App\Models\PengajuanJemaat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengajuanJemaatController extends Controller
{
    public function ViewBaptis(): View
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
    public function TambahBaptis(): View
    {
        return view('PengajuanJemaat.tambah_baptis', [
            'title' => "Tambah Pengajuan Baptis",
            'id_baptis' => PengajuanJemaat::generateNextId(),
        ]);
    }
    public function UbahBaptis(): View
    {
        return view('PengajuanJemaat.ubah_baptis', [
            'title' => 'Ubah Pengajuan Baptis'
        ]);
    }
    public function AddBaptis()
    {
        // TODO: kerjain ini untuk menambahkan data baptis yang sudah diambil dari form
    }
    public function UpdateBaptis()
    {
        // TODO: kerjain ini untuk menambahkan data baptis yang sudah diambil dari form
    }

    public function ViewPernikahan(): View
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
    public function TambahPernikahan(): View
    {
        return view('PengajuanJemaat.tambah_pernikahan', [
            'title' => "Tambah Pengajuan Pernikahan",
            'id_pernikahan' => PengajuanJemaat::generateNextId(),
        ]);
    }
    public function UbahPernikahan(): View
    {
        return view('PengajuanJemaat.ubah_baptis', [
            'title' => 'Ubah Pengajuan Pernikahan'
        ]);
    }
    public function AddPernikahan()
    {
        // TODO: kerjain ini untuk menambahkan data pernikahan yang sudah diambil dari form
    }
    public function UpdatePernikahan()
    {
        // TODO: kerjain ini untuk menambahkan data pernikahan yang sudah diambil dari form
    }

    //ETC
    public function SearchPengajar(Request $request)
    {
        $query = $request->get('q');

        $results = Pelayan::join('jemaat', 'pelayan.id_jemaat', '=', 'jemaat.id_jemaat')
            ->where('jemaat.nama_jemaat', 'like', "%$query%")
            ->select('pelayan.id_pelayan', 'jemaat.nama_jemaat as nama_pengajar')
            ->get();

        return response()->json($results);
    }
    public function SearchPasangan(Request $request)
    {
        $query = $request->get('q');
        $excludeGender = $request->get('exclude_gender');

        // Ambil semua id jemaat yang sudah terdaftar di pernikahan
        $sudahMenikahIds = DB::table('pernikahan')
            ->select('id_jemaat_p as id_jemaat')
            ->union(
                DB::table('pernikahan')->select('id_jemaat_w as id_jemaat')
            )
            ->pluck('id_jemaat');

        $results = Jemaat::where('nama_jemaat', 'like', "%$query%")
            ->when($excludeGender, function ($query, $excludeGender) {
                $oppositeGender = $excludeGender === 'P' ? 'W' : 'P';
                $query->where('jk_jemaat', $oppositeGender);
            })
            ->whereNotIn('id_jemaat', $sudahMenikahIds) // Hindari jemaat yang sudah menikah
            ->select('id_jemaat', 'nama_jemaat as nama_pasangan')
            ->get();

        return response()->json($results);
    }
}
