<?php

namespace Database\Seeders;

use App\Models\Pelayan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelayanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelayan::updateOrCreate(
            ['id_pelayan' => 'PL180903A1'],
            [
                'id_jemaat' => 'JM180903A1',
                'hak_akses_pelayan' => 'Super Admin'
            ]
        );
        Pelayan::updateOrCreate(
            ['id_pelayan' => 'PL010125A1'],
            [
                'id_jemaat' => 'JM010125A3',
                'hak_akses_pelayan' => 'Pelayan Gereja'
            ]
        );
        Pelayan::updateOrCreate(
            ['id_pelayan' => 'PL010125A2'],
            [
                'id_jemaat' => 'JM010125A4',
                'hak_akses_pelayan' => 'Praise & Worship'
            ]
        );
    }
}
