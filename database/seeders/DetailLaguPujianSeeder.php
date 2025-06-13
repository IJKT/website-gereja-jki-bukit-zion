<?php

namespace Database\Seeders;

use App\Models\detail_lagu_pujian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailLaguPujianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        detail_lagu_pujian::updateOrCreate(
            [
                'id_jadwal' => 'JI010125A1',
                'id_lagu' => 'LI010125A1',
                'urutan_lagu' => 1
            ]
        );
        detail_lagu_pujian::updateOrCreate(
            [
                'id_jadwal' => 'JI010125A1',
                'id_lagu' => 'LI010125A2',
                'urutan_lagu' => 2
            ]
        );
        detail_lagu_pujian::updateOrCreate(
            [
                'id_jadwal' => 'JI010125A1',
                'id_lagu' => 'LI010125A3',
                'urutan_lagu' => 3
            ]
        );
        detail_lagu_pujian::updateOrCreate(
            [
                'id_jadwal' => 'JI010125A1',
                'id_lagu' => 'LI010125A4',
                'urutan_lagu' => 4
            ]
        );
    }
}
