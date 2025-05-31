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
                'password' => Hash::make('admin'),
                // TODO: nanti verifikasi_user'nya gak usa diisi kalau register sudah dibikin
                'verifikasi_user' => 1,
            ]
        );

        // TESTER
        User::updateOrCreate(
            ['username' => 'spousetest'],
            [
                'password' => Hash::make('test'),
                // TODO: nanti verifikasi_user'nya gak usa diisi kalau register sudah dibikin
                'verifikasi_user' => 1,
            ]
        );
        User::updateOrCreate(
            ['username' => 'registrationtest'],
            [
                'password' => Hash::make('test')
            ]
        );
        User::updateOrCreate(
            ['username' => 'pendetatest'],
            [
                'password' => Hash::make('pendeta'),
                // TODO: nanti verifikasi_user'nya gak usa diisi kalau register sudah dibikin
                'verifikasi_user' => 1,
            ]
        );
    }
}
