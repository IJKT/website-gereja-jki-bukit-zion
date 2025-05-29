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

    // TODO: tambah function
    // public function tambah(): View
    // {
    //     $id_pembukuan = Pembukuan::generateNextId();

    //     return view(
    //         'Pembukuan.tambah',
    //         [
    //             'title' => 'Tambah Data Pembukuan',
    //             'id_pelayan' => $id_pembukuan
    //         ]
    //     );
    // }

    //TODO: add funtion
    public function add(Request $request)
    {
        $pembukuan = new Pembukuan();
        // TODO: nanti ditambah cara bikin id pembukuannya
        // $pembukuan->id_pembukuan = $id_pembukuan;
        $pembukuan->jenis_pembukuan = $request->jenis_pembukuan;
        $pembukuan->nominal_pembukuan = $request->nominal_pembukuan;
        $pembukuan->tgl_pembukuan = $request->tgl_pembukuan;
        $pembukuan->deskripsi_pembukuan = $request->deskripsi_pembukuan;
        $pembukuan->save();

        return redirect()->route('Pembukuan.viewall');
    }

    //TODO: update function
    public function update(Request $request, Pembukuan $pembukuan)
    {
        // Validate input
        $validated = $request->validate([
            'nominal_pembukuan'   => ['required', 'string'],
            'jenis_pembukuan'     => ['required', 'in:Uang Masuk,Uang Keluar'],
            'deskripsi_pembukuan' => ['nullable', 'string'],
        ]);

        // Remove commas from nominal_pembukuan and convert to integer
        $nominal = (int) str_replace(',', '', $validated['nominal_pembukuan']);
        // @dd([$nominal, $validated['jenis_pembukuan'], $validated['deskripsi_pembukuan']]);

        // Update the Pembukuan record
        $pembukuan->update([
            'nominal_pembukuan'   => $nominal,
            'jenis_pembukuan'     => $validated['jenis_pembukuan'],
            'deskripsi_pembukuan' => $validated['deskripsi_pembukuan'],
        ]);

        // Redirect back with a success message
        return redirect()
            ->route('Pembukuan.viewall')
            ->with('success', 'Data pembukuan berhasil diupdate.');
    }
}
