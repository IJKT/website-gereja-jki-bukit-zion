<?php

namespace App\Http\Controllers;

use App\Models\User;
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
                // TODO: ini kalo kayak auth user
                'user' => User::where('username', 'ishakjoseph')->first(),
            ]
        );
    }
}
