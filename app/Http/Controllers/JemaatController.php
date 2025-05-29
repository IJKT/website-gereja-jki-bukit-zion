<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JemaatController extends Controller
{
    // $jemaat = Jemaat::
    // public function search(Request $request)
    // {
    //     $query = $request->input('query');
    //     $results = Jemaat::where('nama_jemaat', 'like', "%{$query}%")
    //         ->limit(10)
    //         ->get(['id_jemaat', 'nama_jemaat', 'username']);

    //     return response()->json($results);
    // }
    // public $prefix = 'Manajemen.Jemaat.';
    public function viewall(): View
    {
        return view(
            'Manajemen.Jemaat.viewall',
            [
                'title' => 'Manajemen Jemaat',
                'jemaat' => Jemaat::with('user')->simplePaginate(5)
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


    // TODO: tambah function
    //     public function viewall(): View
    //     {
    //         return view($prefix . 'viewall', [
    //             'users' => Jemaat::with('users')->paginate(5)
    //         ]);
    //     }
}
