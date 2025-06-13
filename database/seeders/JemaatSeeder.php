<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Jemaat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

        // // TESTER
        $jemaatData = [
            ['id' => 'JM010125A1', 'username' => 'antoniussutardjo', 'nama' => 'Antonius Sutardjo', 'jk' => 'P', 'akses' => 'Pelayan', 'alamat' => 'Manyar Jaya XI/18', 'telpon' => '083115685687', 'tgl_lahir' => '1956-07-14'],
            ['id' => 'JM010125A2', 'username' => 'lenawatiteguh', 'nama' => 'Lenawati Teguh', 'jk' => 'W', 'akses' => 'Pelayan', 'alamat' => 'Manyar Jaya XI/18', 'telpon' => '83145507140', 'tgl_lahir' => '1956-09-14'],
            ['id' => 'JM010125A3', 'username' => 'arumningsih', 'nama' => 'Arum Ningsih', 'jk' => 'W', 'akses' => 'Pelayan', 'alamat' => 'Kali Kepiting Jaya III no 5', 'telpon' => '811375317', 'tgl_lahir' => '1965-10-10'],
            ['id' => 'JM010125A4', 'username' => 'debora.sukidjo', 'nama' => 'Debora Sukidjo', 'jk' => 'W', 'akses' => 'Pelayan', 'alamat' => 'Menanggal I/35 B', 'telpon' => '85648211407', 'tgl_lahir' => '1963-10-22'],
            ['id' => 'JM010125A5', 'username' => 'djojosudigdo', 'nama' => 'Djojo Sudigdo', 'jk' => 'P', 'akses' => 'Pelayan', 'alamat' => 'Kasuari 25', 'telpon' => '83856064662', 'tgl_lahir' => '1962-09-28'],
            ['id' => 'JM010125A6', 'username' => 'emanuelnahak', 'nama' => 'Emanuel Nahak', 'jk' => 'P', 'akses' => 'Pelayan', 'alamat' => 'Cipta Menanggal 1 blok 4 D1', 'telpon' => '81216567073', 'tgl_lahir' => '1960-09-20'],
            ['id' => 'JM010125A7', 'username' => 'elsyetansil', 'nama' => 'Elsye Tansil', 'jk' => 'W', 'alamat' => 'Apartemen Dharma Husada Indah', 'telpon' => '85235864577', 'tgl_lahir' => '1957-01-13'],
            ['id' => 'JM010125A8', 'username' => 'harjatitjahjani', 'nama' => 'Harjati Tjahjani', 'jk' => 'W', 'alamat' => 'MWonorejo Permai Selatan I/7 cc 31', 'telpon' => '82177382018', 'tgl_lahir' => '1943-05-12'],
            ['id' => 'JM010125A9', 'username' => 'hariwidhayani', 'nama' => 'Hari Widhayani', 'jk' => 'W', 'alamat' => 'Gebang Kidul 43', 'telpon' => '8165435820', 'tgl_lahir' => '1956-01-21'],
            ['id' => 'JM010125B1', 'username' => 'hanshendrikpangkey', 'nama' => 'Hans Hendrik Pangkey', 'jk' => 'P', 'alamat' => 'Medayu Selatan 9/15', 'telpon' => '82139053328', 'tgl_lahir' => '1952-05-20'],
            ['id' => 'JM010125B2', 'username' => 'jonathanwantoro', 'nama' => 'Jonathan Wantoro', 'jk' => 'P', 'alamat' => 'Juanda Harapan Permai 627 SDA', 'telpon' => '8123256551', 'tgl_lahir' => '1961-04-14'],
            ['id' => 'JM010125B3', 'username' => 'liemindra', 'nama' => 'Liem Indra', 'jk' => 'W', 'alamat' => 'Kutisari Indah Barat IX/34', 'telpon' => '89616078608', 'tgl_lahir' => '1946-03-16'],
        ];

        foreach ($jemaatData as $data) {
            Jemaat::updateOrCreate(
                ['id_jemaat' => $data['id']],
                [
                    'username'           => $data['username'],
                    'nama_jemaat'        => $data['nama'],
                    'jk_jemaat'          => $data['jk'],
                    'nik_jemaat'         => fake()->numerify('################'),
                    'tmpt_lahir_jemaat'  => fake()->city(),
                    'tgl_lahir_jemaat'   => $data['tgl_lahir'],
                    'tgl_daftar_jemaat'  => Carbon::now(),
                    'telp_jemaat'        => $data['telpon'],
                    'email_jemaat'       => fake()->unique()->safeEmail(),
                    'alamat_jemaat'      => $data['alamat'],
                    'hak_akses_jemaat'   => $data['akses'] ?? 'Jemaat',
                ]
            );
        }
    }
}
