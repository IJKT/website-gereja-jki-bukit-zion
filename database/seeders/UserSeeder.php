<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'ishakjoseph'],
            [
                'password' => bcrypt('admin'),
                // TODO: nanti verifikasi_user'nya gak usa diisi kalau register sudah dibikin
                'verifikasi_user' => 1,
            ]
        );

        // TESTER
        $users = [
            'antoniussutardjo',
            'lenawatiteguh',
            'arumningsih',
            'debora.sukidjo',
            'djojosudigdo',
            'emanuelnahak',
            'elsyetansil',
            'harjatitjahjani',
            'hariwidhayani',
            'hanshendrikpangkey',
            'jonathanwantoro',
            'liemindra',
        ];
        foreach ($users as $username) {
            User::updateOrCreate(
                ['username' => $username],
                [
                    'password' => bcrypt('password'),
                    'verifikasi_user' => 1,
                ]
            );
        }
    }
}
