<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Baptis;
use App\Models\Jemaat;
use App\Models\Riwayat;
use Illuminate\View\View;
use App\Models\Pernikahan;
use Illuminate\Http\Request;
use App\Models\PengajuanJemaat;
use App\Models\RevisiPengajuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JemaatController extends Controller
{
    // MENAMPILKAN HALAMAN
    public function viewall(Request $request): View
    {
        $jemaat = Jemaat::with('user')
            ->whereHas('user', function ($query) {
                $query->where('verifikasi_user', '=', '1');
            })
            ->orderBy('nama_jemaat', 'asc');

        // Filter by hak_akses if present and not empty
        if ($request->filled('hak_akses_jemaat')) {
            $jemaat->where('hak_akses_jemaat', $request->hak_akses_jemaat);
        }

        return view(
            'Manajemen.Jemaat.viewall',
            [
                'title' => 'Manajemen Jemaat',
                'jemaat' => $jemaat->paginate(5)->WithQueryString()
            ]
        );
    }
    public function ubah(Jemaat $jemaat): View
    {
        $baptis = PengajuanJemaat::where('id_jemaat', $jemaat->id_jemaat)->where('jenis_pengajuan', 'Baptis')->first();
        $pernikahan = PengajuanJemaat::where('id_jemaat', $jemaat->id_jemaat)->where('jenis_pengajuan', 'Pernikahan')->first();
        return view(
            'Manajemen.Jemaat.ubah',
            [
                'title' => 'Ubah Data Jemaat',
                'jemaat' => $jemaat,
                'baptis' => $baptis,
                'pernikahan' => $pernikahan
            ]
        );
    }

    public function unduh(Request $request)
    {
        $jemaat = Jemaat::orderBy('nama_jemaat')->get();


        $pdf = Pdf::loadView('Exports.jemaat_file', [
            'jemaat' => $jemaat,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Daftar Jemaat JKI Bukit Zion.pdf');
    }
    public function pengajuanViewall(Request $request): View
    {
        $pengajuan_jemaat = PengajuanJemaat::with('jemaat');

        // Filter by hak_akses if present and not empty
        if ($request->filled('jenis_pengajuan')) {
            $pengajuan_jemaat->where('jenis_pengajuan', $request->jenis_pengajuan);
        }

        return view(
            'Manajemen.Jemaat.Pengajuan.viewall',
            [
                'title' => 'Manajemen Pengajuan Jemaat',
                'pengajuan_jemaat' => $pengajuan_jemaat->orderBy('verifikasi_pengajuan', 'asc')->paginate(5)->withQueryString()
            ]
        );
    }
    public function pengajuanVerifikasiBaptis(PengajuanJemaat $pengajuan_jemaat): View
    {
        $data_baptis = $pengajuan_jemaat::where('id_jemaat', $pengajuan_jemaat->id_jemaat)
            ->where('jenis_pengajuan', 'Baptis')
            ->first();
        $detail_baptis = Baptis::where('id_baptis', $data_baptis->id_pengajuan)->first();
        $data_revisi = RevisiPengajuan::where('id_revisi', $data_baptis->id_pengajuan)->orderByDesc('tgl_revisi')->paginate(3);
        return view(
            'Manajemen.Jemaat.Pengajuan.verifikasi_baptis',
            [
                'title' => 'Verifikasi Pengajuan Baptis',
                'pengajuan_jemaat' => $data_baptis,
                'detail_baptis' => $detail_baptis,
                'data_revisi' => $data_revisi,
            ]
        );
    }
    public function pengajuanVerifikasiPernikahan(PengajuanJemaat $pengajuan_jemaat): View
    {
        $data_pernikahan = $pengajuan_jemaat::where('id_jemaat', $pengajuan_jemaat->id_jemaat)
            ->where('jenis_pengajuan', 'Pernikahan')
            ->first();
        $detail_pernikahan = Pernikahan::where('id_pernikahan', $data_pernikahan->id_pengajuan)->first();
        $data_revisi = RevisiPengajuan::where('id_revisi', $data_pernikahan->id_pengajuan)->orderByDesc('tgl_revisi')->paginate(3);
        return view(
            'Manajemen.Jemaat.Pengajuan.verifikasi_pernikahan',
            [
                'title' => 'Verifikasi Pengajuan Pernikahan',
                'pengajuan_jemaat' => $data_pernikahan,
                'detail_pernikahan' => $detail_pernikahan,
                'data_revisi' => $data_revisi,
            ]
        );
    }
    public function pengajuanVerifikasiRegistrasi(PengajuanJemaat $pengajuan_jemaat): View
    {
        return view(
            'Manajemen.Jemaat.Pengajuan.verifikasi_registrasi',
            [
                'title' => 'Verifikasi Pengajuan Jemaat Tetap',
                'pengajuan_jemaat' => $pengajuan_jemaat
            ]
        );
    }
    public function pengajuanUnduh(Request $request)
    {
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $pengajuan = PengajuanJemaat::whereBetween('tanggal_pengajuan', [$startOfMonth, $endOfMonth])
            ->orderBy('tanggal_pengajuan')
            ->get();


        $pdf = Pdf::loadView('Exports.pengajuan_file', [
            'pengajuan' => $pengajuan,
        ]);

        return $pdf->download('Daftar Pengajuan Jemaat JKI Bukit Zion.pdf');
    }

    // UNTUK SEMUA PUT FUNCTION
    public function update(Request $request, Jemaat $jemaat)
    {
        // dd($request);
        $jemaat->update([
            // nama email NIK alamat ttl telp hak akses jk
            'nama_jemaat' => $request->input('nama_jemaat'),
            'jk_jemaat' => $request->input('jk_jemaat'),
            'nik_jemaat' => $request->input('nik_jemaat'),
            'tmpt_lahir_jemaat' => $request->input('tmpt_lahir_jemaat'),
            'tgl_lahir_jemaat' => $request->input('tgl_lahir_jemaat'),
            'telp_jemaat' => $request->input('telp_jemaat'),
            'email_jemaat' => $request->input('email_jemaat'),
            'alamat_jemaat' => $request->input('alamat_jemaat'),
            'hak_akses_jemaat' => $request->input('hak_akses_jemaat')
        ]);

        Riwayat::logChange(2, $jemaat->id_jemaat, Auth::user()->jemaat->pelayan->id_pelayan);
        // Redirect back with a success message
        return redirect()->route('Manajemen.Jemaat.viewall');
    }
    public function status(Request $request, Jemaat $jemaat)
    {
        $jemaat->update([
            'status_jemaat' => $request->status_jemaat
        ]);

        Riwayat::logChange(2, $jemaat->id_jemaat, Auth::user()->jemaat->pelayan->id_pelayan);
        // Redirect back with a success message
        return redirect()->route('Manajemen.Jemaat.viewall');
    }
    public function pengajuanVerifyBaptis(Request $request, Baptis $baptis)
    {
        $baptis->update([
            // 'komentar_baptis' => $request->catatan_pengajuan,
            'id_pembaptis' => $request->id_pembaptis,
            'tgl_baptis' => $request->tgl_baptis
        ]);

        $pengajuan_jemaat = PengajuanJemaat::where('id_pengajuan', $baptis->id_baptis)->first();
        if ($pengajuan_jemaat) {
            $pengajuan_jemaat->update([
                'verifikasi_pengajuan' => $request->verifikasi_pengajuan
            ]);
        }
        if ($request->verifikasi_pengajuan == 1) {
            // apabila verifikasi diterima
            Riwayat::logChange(4, $baptis->id_baptis, Auth::user()->jemaat->pelayan->id_pelayan);
        } else {
            // apabila verifikasi ditolak
            Riwayat::logChange(5, $baptis->id_baptis, Auth::user()->jemaat->pelayan->id_pelayan);
            RevisiPengajuan::addRevision($baptis->id_baptis, Auth::user()->jemaat->pelayan->id_pelayan,  $request->catatan_pengajuan);
        }
        // Redirect back with a success message
        return redirect()->route('Manajemen.Jemaat.Pengajuan.viewall');
    }
    public function pengajuanVerifyPernikahan(Request $request, Pernikahan $pernikahan)
    {
        // dd([$request->catatan_pengajuan, $request->id_pendeta, $request->verifikasi_pengajuan]);
        $pernikahan->update([
            // 'komentar_pernikahan' => $request->catatan_pengajuan,
            'id_pendeta' => $request->id_pendeta
        ]);

        $pengajuan_jemaat = PengajuanJemaat::where('id_pengajuan', $pernikahan->id_pernikahan)->first();
        if ($pengajuan_jemaat) {
            $pengajuan_jemaat->update([
                'verifikasi_pengajuan' => $request->verifikasi_pengajuan
            ]);
        }

        if ($request->verifikasi_pengajuan == 1) {
            // apabila verifikasi diterima
            Riwayat::logChange(4, $pernikahan->id_pernikahan, Auth::user()->jemaat->pelayan->id_pelayan);
        } else {
            // apabila verifikasi ditolak
            Riwayat::logChange(5, $pernikahan->id_pernikahan, Auth::user()->jemaat->pelayan->id_pelayan);
            RevisiPengajuan::addRevision($pernikahan->id_pernikahan, Auth::user()->jemaat->pelayan->id_pelayan,  $request->catatan_pengajuan);
        }

        // Redirect back with a success message
        return redirect()->route('Manajemen.Jemaat.Pengajuan.viewall');
    }
    public function pengajuanVerifyRegistrasi(Request $request, PengajuanJemaat $pengajuan_jemaat)
    {
        $pengajuan_jemaat->update([

            'verifikasi_pengajuan' => $request->verifikasi_pengajuan
        ]);

        $user = User::where('username', $pengajuan_jemaat->jemaat->username)->first();
        if ($user) {
            $user->update([
                'catatan_verif_user' => $request->catatan_pengajuan,
                'verifikasi_user' => $request->verifikasi_pengajuan
            ]);
        }

        if ($request->verifikasi_pengajuan == 1) {
            // apabila verifikasi diterima
            Riwayat::logChange(4, $pengajuan_jemaat->id_pengajuan, Auth::user()->jemaat->pelayan->id_pelayan);
        } else {
            // apabila verifikasi ditolak
            // TODO: tambahkan alasan penolakan di detail riwayat
            Riwayat::logChange(5, $pengajuan_jemaat->id_pengajuan, Auth::user()->jemaat->pelayan->id_pelayan);
        }

        return redirect()->route('Manajemen.Jemaat.Pengajuan.viewall');
    }

    // ETC
    public function search(Request $request)
    {
        $query = $request->get('q');

        // Join pelayan and jemaat tables to get id_pelayan and nama_jemaat
        $results = DB::table('pelayan')
            ->join('jemaat', 'pelayan.id_jemaat', '=', 'jemaat.id_jemaat')
            ->where('jemaat.nama_jemaat', 'like', "%$query%")
            ->select('pelayan.id_pelayan', 'jemaat.nama_jemaat')
            ->get();

        return response()->json($results);
    }
}
