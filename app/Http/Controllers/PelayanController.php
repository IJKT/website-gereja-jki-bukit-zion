<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use App\Models\Pelayan;
use App\Models\Riwayat;
use Illuminate\View\View;
use Illuminate\Http\Request;

class PelayanController extends Controller
{
    // UNTUK SEMUA VIEW
    public function viewall(): View
    {
        return view(
            'Manajemen.Pelayan.viewall',
            [
                'title' => 'Manajemen Pelayan',
                'pelayan' => Pelayan::with('jemaat')->paginate(5)
            ]
        );
    }
    public function ubah(Pelayan $pelayan): View
    {
        return view(
            'Manajemen.Pelayan.ubah',
            [
                'title' => 'Ubah Data Pelayan',
                'pelayan' => $pelayan
            ]
        );
    }
    public function tambah(): View
    {
        $id_pelayan = Pelayan::generateNextId();

        return view(
            'Manajemen.Pelayan.tambah',
            [
                'title' => 'Tambah Data Pelayan',
                'id_pelayan' => $id_pelayan
            ]
        );
    }

    // UNTUK SEMUA PUT FUNCTION
    public function update(Request $request, Pelayan $pelayan)
    {
        // Update the pelayan record
        $pelayan->update([
            'hak_akses_pelayan' => $request->input('hak_akses_pelayan')
        ]);

        Riwayat::logChange(2, $pelayan->id_pelayan, null);
        // Redirect back with a success message
        return redirect()->route('Manajemen.Pelayan.viewall');
    }
    public function status(Request $request, Pelayan $pelayan)
    {
        $pelayan->update([
            'status_pelayan' => $request->status_pelayan
        ]);

        Riwayat::logChange(2, $pelayan->id_pelayan, null);
        // Redirect back with a success message
        return redirect()->route('Manajemen.Pelayan.viewall');
    }
    public function add(Request $request)
    {
        $pelayan = new Pelayan();
        $pelayan->id_pelayan = $request->id_pelayan;
        $pelayan->id_jemaat = $request->id_jemaat;
        $pelayan->hak_akses_pelayan = $request->hak_akses_pelayan;
        $pelayan->save();

        Riwayat::logChange(1, $request->id_pelayan, null);
        return redirect()->route('Manajemen.Pelayan.viewall');
    }

    // ETC:
    public function search(Request $request)
    {
        $query = $request->get('q');

        $results = Jemaat::where('nama_jemaat', 'like', "%$query%")
            ->where('hak_akses_jemaat', 'Pelayan')
            ->select('id_jemaat', 'nama_jemaat')
            ->get();

        return response()->json($results);
    }
}
