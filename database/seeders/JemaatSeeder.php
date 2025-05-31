<?php

namespace Database\Seeders;

use App\Models\Jemaat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JemaatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Jemaat::updateOrCreate(
            ['id_jemaat' => 'JM180903A1'],
            [
                'username' => 'ishakjoseph',
                'nama_jemaat' => 'Ishak Joseph Kurniawan',
                'jk_jemaat' => 'P',
                'nik_jemaat' => '3578151809030003',
                'tmpt_lahir_jemaat' => 'Surabaya',
                'tgl_lahir_jemaat' => '2003-09-18',
                'tgl_daftar_jemaat' => now(),
                'telp_jemaat' => '085176831891',
                'email_jemaat' => 'ishakjosephk@gmail.com',
                'alamat_jemaat' => 'Jl. Kasuari no.25',
                'hak_akses_jemaat' => 'Pelayan',
            ]
        );

        // TESTER
        Jemaat::updateOrCreate(
            ['id_jemaat' => 'JM010125A1'],
            [
                'username' => 'spousetest',
                'nama_jemaat' => 'Coba Coba Pasangan',
                'jk_jemaat' => 'W',
                'nik_jemaat' => fake()->numerify('################'),
                'tmpt_lahir_jemaat' => fake()->city(),
                'tgl_lahir_jemaat' => fake()->date(),
                'tgl_daftar_jemaat' => now(),
                'telp_jemaat' => fake()->phoneNumber(),
                'email_jemaat' => fake()->unique()->safeEmail(),
                'alamat_jemaat' => fake()->address()
            ]
        );
        Jemaat::updateOrCreate(
            ['id_jemaat' => 'JM010125A2'],
            [
                'username' => 'registrationtest',
                'nama_jemaat' => 'Coba Coba Registrasi',
                'jk_jemaat' => 'W',
                'nik_jemaat' => fake()->numerify('################'),
                'tmpt_lahir_jemaat' => fake()->city(),
                'tgl_lahir_jemaat' => fake()->date(),
                'tgl_daftar_jemaat' => now(),
                'telp_jemaat' => fake()->phoneNumber(),
                'email_jemaat' => fake()->unique()->safeEmail(),
                'alamat_jemaat' => fake()->address()
            ]
        );
        Jemaat::updateOrCreate(
            ['id_jemaat' => 'JM010125A3'],
            [
                'username' => 'pendetatest',
                'nama_jemaat' => 'Coba Coba Pendeta',
                'jk_jemaat' => 'P',
                'nik_jemaat' => fake()->numerify('################'),
                'tmpt_lahir_jemaat' => fake()->city(),
                'tgl_lahir_jemaat' => fake()->date(),
                'tgl_daftar_jemaat' => now(),
                'telp_jemaat' => fake()->phoneNumber(),
                'email_jemaat' => fake()->unique()->safeEmail(),
                'alamat_jemaat' => fake()->address(),
                'hak_akses_jemaat' => 'Pelayan',
            ]
        );
    }
}
