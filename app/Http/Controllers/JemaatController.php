<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use App\Models\Riwayat;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Baptis;
use App\Models\PengajuanJemaat;
use App\Models\Pernikahan;
use App\Models\User;

// TODO: bikin pekerjaan_jemaat dan wilayah komsel nanti di database

class JemaatController extends Controller
{
    // MENAMPILKAN HALAMAN
    public function viewall(): View
    {
        return view(
            'Manajemen.Jemaat.viewall',
            [
                'title' => 'Manajemen Jemaat',
                'jemaat' => Jemaat::with('user')
                    ->whereHas('user', function ($query) {
                        $query->where('verifikasi_user', '=', '1');
                    })
                    ->orderBy('nama_jemaat', 'asc')
                    ->paginate(5)
            ]
        );
    }
    public function ubah(Jemaat $jemaat): View
    {
        return view(
            'Manajemen.Jemaat.ubah',
            [
                'title' => 'Ubah Data Jemaat',
                'jemaat' => $jemaat
            ]
        );
    }
    public function pengajuanViewall(): View
    {
        return view(
            'Manajemen.Jemaat.Pengajuan.viewall',
            [
                'title' => 'Manajemen Pengajuan Jemaat',
                'pengajuan_jemaat' => PengajuanJemaat::with('jemaat')->paginate(5)
            ]
        );
    }
    public function pengajuanVerifikasiBaptis(Baptis $pengajuan_jemaat): View
    {
        return view(
            'Manajemen.Jemaat.Pengajuan.verifikasi_baptis',
            [
                'title' => 'Verifikasi Pengajuan Baptis',
                'pengajuan_jemaat' => $pengajuan_jemaat
            ]
        );
    }
    public function pengajuanVerifikasiPernikahan(Pernikahan $pengajuan_jemaat): View
    {
        return view(
            'Manajemen.Jemaat.Pengajuan.verifikasi_pernikahan',
            [
                'title' => 'Verifikasi Pengajuan Pernikahan',
                'pengajuan_jemaat' => $pengajuan_jemaat
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

        Riwayat::logChange(2, $jemaat->id_jemaat, null);
        // Redirect back with a success message
        return redirect()->route('Manajemen.Jemaat.viewall');
    }
    public function status(Request $request, Jemaat $jemaat)
    {
        $jemaat->update([
            'status_jemaat' => $request->status_jemaat
        ]);

        Riwayat::logChange(2, $jemaat->id_jemaat, null);
        // Redirect back with a success message
        return redirect()->route('Manajemen.Jemaat.viewall');
    }
    public function pengajuanVerifyBaptis(Request $request, PengajuanJemaat $pengajuan_jemaat)
    {
        $pengajuan_jemaat->update([
            'verifikasi_pengajuan' => $request->verifikasi_pengajuan
        ]);

        Riwayat::logChange(2, $pengajuan_jemaat->id_pengajuan, null);
        // Redirect back with a success message
        return redirect()->route('Manajemen.Jemaat.Pengajuan.viewall');
    }
    public function pengajuanVerifyPernikahan(Request $request, PengajuanJemaat $pengajuan_jemaat)
    {
        $pengajuan_jemaat->update([
            'verifikasi_pengajuan' => $request->verifikasi_pengajuan
        ]);

        Riwayat::logChange(2, $pengajuan_jemaat->id_pengajuan, null);
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

        Riwayat::logChange(2, $pengajuan_jemaat->id_pengajuan, null);
        // Redirect back with a success message
        return redirect()->route('Manajemen.Jemaat.Pengajuan.viewall');
    }
}
