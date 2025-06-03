<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function profil(): View
    {
        return view(
            'Profil.profile',
            [
                'title' => "Halaman Profil",
                'nama_lengkap' => 'John Doe',
                'email' => 'johndoe@gmail.com',
                'nik' => '1234567890',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '01-01-2025',
                'alamat' => 'Jl. Lorem Ipsum no. 1',
                'jenis_kelamin' => 'P',
                'nomor_hp' => '081234567890'
            ]
        );
    }
}
