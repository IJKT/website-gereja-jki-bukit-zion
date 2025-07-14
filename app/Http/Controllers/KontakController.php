<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\Riwayat;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Mail\BalasanKontakMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class KontakController extends Controller
{
    public function Index(Request $request): View
    {
        $kontak = Kontak::where('status', 0);

        if ($request->filled('kategori')) {
            $kontak->where('kategori', $request->kategori);
        }

        return view(
            'Kontak.index',
            [
                'title' => 'Halaman Kontak',
                'kontak' =>  $kontak->paginate(5)->WithQueryString()
            ]
        );
    }
    public function Balas(Kontak $kontak): View
    {
        return view(
            'Kontak.balas',
            [
                'title' => 'Balas Pesan',
                'kontak' => $kontak,
            ]
        );
    }

    // PUT FUNCTION
    public function Send(Request $request, Kontak $kontak)
    {
        $kontak->status = 1;
        $kontak->save();

        Mail::to($kontak->email)->send(new BalasanKontakMail($request->balasan, $kontak->pesan));

        Riwayat::logChange(2, $kontak->id_kontak, Auth::user()->jemaat->pelayan->id_pelayan);
        return redirect()->route('Kontak.index');
    }
}
