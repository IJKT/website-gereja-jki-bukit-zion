<?php

namespace App\Http\Controllers;

use App\Models\Pelayan;
use Illuminate\View\View;
use Illuminate\Http\Request;

class PelayanController extends Controller
{
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
}
