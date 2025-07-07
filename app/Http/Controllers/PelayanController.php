<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use App\Models\Pelayan;
use App\Models\Riwayat;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PelayanController extends Controller
{
    // UNTUK SEMUA VIEW
    public function viewall(Request $request): View
    {
        $pelayan = Pelayan::join('jemaat', 'pelayan.id_jemaat', '=', 'jemaat.id_jemaat')
            ->orderBy('jemaat.nama_jemaat', 'asc')
            ->select('pelayan.*') // pilih hanya kolom dari pelayan
            ->with('jemaat');       // tetap eager load jemaat

        // Filter by hak_akses if present and not empty
        if ($request->filled('hak_akses')) {
            $pelayan->where('hak_akses_pelayan', $request->hak_akses);
        }

        return view(
            'Manajemen.Pelayan.viewall',
            [
                'title' => 'Manajemen Pelayan',
                'pelayan' => $pelayan->paginate(5)->withQueryString()

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
    public function unduh(Request $request)
    {
        $pelayan = Pelayan::orderBy('hak_akses_pelayan')->get();

        $pdf = Pdf::loadView('Exports.pelayan_file', [
            'pelayan' => $pelayan,
        ]);

        return $pdf->download('Daftar Pelayan JKI Bukit Zion.pdf');
    }

    // UNTUK SEMUA PUT FUNCTION
    public function update(Request $request, Pelayan $pelayan)
    {
        // Update the pelayan record
        $pelayan->update([
            'hak_akses_pelayan' => $request->input('hak_akses_pelayan')
        ]);

        Riwayat::logChange(2, $pelayan->id_pelayan, Auth::user()->jemaat->pelayan->id_pelayan);
        // Redirect back with a success message
        return redirect()->route('Manajemen.Pelayan.viewall');
    }
    public function status(Request $request, Pelayan $pelayan)
    {
        $pelayan->update([
            'status_pelayan' => $request->status_pelayan
        ]);

        Riwayat::logChange(2, $pelayan->id_pelayan, Auth::user()->jemaat->pelayan->id_pelayan);
        // Redirect back with a success message
        return redirect()->route('Manajemen.Pelayan.viewall');
    }
    public function add(Request $request)
    {
        $pelayan = new Pelayan();
        $pelayan->id_pelayan = Pelayan::generateNextId();
        $pelayan->id_jemaat = $request->id_jemaat;
        $pelayan->hak_akses_pelayan = $request->hak_akses_pelayan;
        $pelayan->save();

        // Update hak_akses_jemaat to 'Pelayan' in the jemaat table
        $jemaat = Jemaat::find($request->id_jemaat);
        if ($jemaat) {
            $jemaat->hak_akses_jemaat = 'Pelayan';
            $jemaat->save();
        }

        Riwayat::logChange(1, $request->id_pelayan, Auth::user()->jemaat->pelayan->id_pelayan);
        return redirect()->route('Manajemen.Pelayan.viewall');
    }
    // ETC:
    public function search(Request $request)
    {
        $query = $request->get('q');

        $results = Jemaat::where('nama_jemaat', 'like', "%$query%")
            ->where('hak_akses_jemaat', 'Jemaat')
            ->select('id_jemaat', 'nama_jemaat')
            ->get();

        return response()->json($results);
    }
}
