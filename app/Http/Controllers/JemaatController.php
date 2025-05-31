<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use App\Models\Riwayat;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JemaatController extends Controller
{
    // MENAMPILKAN HALAMAN
    public function viewall(): View
    {
        return view(
            'Manajemen.Jemaat.viewall',
            [
                'title' => 'Manajemen Jemaat',
                'jemaat' => Jemaat::with('user')->paginate(5)
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
}
