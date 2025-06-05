<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use App\Models\PengajuanJemaat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function profil(): View
    {
        $user = User::where('username', Auth::user()->username)->first();
        if ($user->verifikasi_user != 1) {
            return view(
                'Profil.review',
                [
                    'title' => "Halaman Profil",
                    'user' => $user,
                ]
            );
        }
        return view(
            'Profil.profile',
            [
                'title' => "Halaman Profil",
                'user' => $user,
            ]
        );
    }
    public function update(Request $request, User $user)
    {
        $jemaat = Jemaat::where('username', $user->username)->first();
        // Update the jemaat record
        $jemaat->update([
            'nama_jemaat' => $request->nama,
            'jk_jemaat' => $request->jk,
            'nik_jemaat' => $request->nik,
            'tmpt_lahir_jemaat' => $request->tempat_lahir,
            'tgl_lahir_jemaat' => $request->tanggal_lahir,
            'email_jemaat' => $request->email,
            'alamat_jemaat' => $request->alamat,
            'telp_jemaat' => $request->nomor_hp,
            'wilayah_komsel_jemaat' => $request->komsel
        ]);

        if ($user->verifikasi_user != 1) {
            PengajuanJemaat::where('id_jemaat', $jemaat->id_jemaat)->update([
                'verifikasi_pengajuan' => 0,
            ]);
        }

        return redirect()->back();
    }
}
