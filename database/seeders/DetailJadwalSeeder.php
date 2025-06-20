<?php

namespace Database\Seeders;

use App\Models\detail_jadwal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailJadwalSeeder extends Seeder
{
    public function run(): void
    {
        detail_jadwal::updateOrCreate(
            [
                'id_jadwal' => ('JI010125A1'),
                'id_pelayan' => ('PL010125A1'),
                'peran_pelayan' => ('1')
            ]
        );
        detail_jadwal::updateOrCreate(
            [
                'id_jadwal' => ('JI010125A1'),
                'id_pelayan' => ('PL010125A4'),
                'peran_pelayan' => ('5')
            ]
        );
        detail_jadwal::updateOrCreate(
            [
                'id_jadwal' => ('JI010125A1'),
                'id_pelayan' => ('PL010125A2'),
                'peran_pelayan' => ('8')
            ]
        );
    }
}
