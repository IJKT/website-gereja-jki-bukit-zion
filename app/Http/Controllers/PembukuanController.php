<?php

namespace App\Http\Controllers;

use App\Models\Pembukuan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PembukuanController extends Controller
{
    public function viewall(): View
    {
        return view(
            'Pembukuan.viewall',
            [
                'title' => 'Halaman Pembukuan',
                'pembukuan' => Pembukuan::simplePaginate(5)
            ]
        );
    }

    //TODO: ubah function
    public function ubah(Pembukuan $pembukuan): View
    {
        return view(
            'Pembukuan.ubah',
            [
                'title' => 'Ubah Data Pembukuan',
                'pembukuan' => $pembukuan
            ]
        );
    }

    public function tambah(): View
    {
        $id_pembukuan = Pembukuan::generateNextId();

        return view(
            'Pembukuan.tambah',
            [
                'title' => 'Tambah Data Pembukuan',
                'id_pembukuan' => $id_pembukuan
            ]
        );
    }

    public function add(Request $request)
    {
        $pembukuan = new Pembukuan();
        // TODO: nanti ditambah cara bikin id pembukuannya
        $pembukuan->id_pembukuan = $request->id_pembukuan;
        $pembukuan->jenis_pembukuan = $request->jenis_pembukuan;
        $pembukuan->nominal_pembukuan = $request->nominal_pembukuan;
        $pembukuan->tgl_pembukuan = $request->tgl_pembukuan;
        $pembukuan->deskripsi_pembukuan = $request->deskripsi_pembukuan;
        $pembukuan->save();

        return redirect()->route('Pembukuan.viewall');

        // // Validate input
        // $validated = $request->validate([
        //     'id_pembukuan'   => ['required', 'string'],
        //     'nominal_pembukuan'   => ['required', 'string'],
        //     'tgl_pembukuan'   => ['required', 'date'],
        //     'jenis_pembukuan'     => ['required', 'in:Uang Masuk,Uang Keluar'],
        //     'deskripsi_pembukuan' => ['nullable', 'string'],
        // ]);

        // // Remove commas from nominal_pembukuan and convert to integer
        // $nominal = (int) str_replace(',', '', $validated['nominal_pembukuan']);

        // // Update the Pembukuan record
        // Pembukuan::create([
        //     'id_pembukuan'   => $validated['id_pembukuan'],
        //     'nominal_pembukuan'   => $nominal,
        //     'jenis_pembukuan'     => $validated['jenis_pembukuan'],
        //     'tgl_pembukuan'     => $validated['tgl_pembukuan'],
        //     'deskripsi_pembukuan' => $validated['deskripsi_pembukuan']
        // ]);

        // // Redirect back with a success message
        // return redirect()->route('Pembukuan.viewall');
    }

    //TODO: update function
    public function update(Request $request, Pembukuan $pembukuan)
    {
        // Validate input
        $validated = $request->validate([
            'nominal_pembukuan'   => ['required', 'string'],
            'tgl_pembukuan'   => ['required', 'date'],
            'jenis_pembukuan'     => ['required', 'in:Uang Masuk,Uang Keluar'],
            'deskripsi_pembukuan' => ['nullable', 'string'],
        ]);

        // Remove commas from nominal_pembukuan and convert to integer
        $nominal = (int) str_replace(',', '', $validated['nominal_pembukuan']);

        // Update the Pembukuan record
        $pembukuan->update([
            'nominal_pembukuan'   => $nominal,
            'jenis_pembukuan'     => $validated['jenis_pembukuan'],
            'tgl_pembukuan'     => $validated['tgl_pembukuan'],
            'deskripsi_pembukuan' => $validated['deskripsi_pembukuan'],
            'verifikasi_pembukuan' => 0,
        ]);

        // Redirect back with a success message
        return redirect()->route('Pembukuan.viewall');
    }
}
