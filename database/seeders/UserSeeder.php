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
        User::updateOrCreate(
            ['username' => 'spousetest'],
            [
                'password' => bcrypt('test'),
                // TODO: nanti verifikasi_user'nya gak usa diisi kalau register sudah dibikin
                'verifikasi_user' => 1,
            ]
        );
        User::updateOrCreate(
            ['username' => 'registrationtest'],
            [
                'password' => bcrypt('test')
            ]
        );
        User::updateOrCreate(
            ['username' => 'pendetatest'],
            [
                'password' => bcrypt('pendeta'),
                // TODO: nanti verifikasi_user'nya gak usa diisi kalau register sudah dibikin
                'verifikasi_user' => 1,
            ]
        );
        User::updateOrCreate(
            ['username' => 'mulmedtest'],
            [
                'password' => bcrypt('multimedia'),
                // TODO: nanti verifikasi_user'nya gak usa diisi kalau register sudah dibikin
                'verifikasi_user' => 1,
            ]
        );
        User::updateOrCreate(
            ['username' => 'mulmedtest2'],
            [
                'password' => bcrypt('multimedia'),
                // TODO: nanti verifikasi_user'nya gak usa diisi kalau register sudah dibikin
                'verifikasi_user' => 1,
            ]
        );
        User::updateOrCreate(
            ['username' => 'pawtest'],
            [
                'password' => bcrypt('praiseworship'),
                // TODO: nanti verifikasi_user'nya gak usa diisi kalau register sudah dibikin
                'verifikasi_user' => 1,
            ]
        );
    }
}
