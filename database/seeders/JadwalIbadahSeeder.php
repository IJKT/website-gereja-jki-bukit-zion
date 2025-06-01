<?php

namespace Database\Seeders;

use App\Models\jadwal_ibadah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadwalIbadahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        jadwal_ibadah::updateOrCreate(
            [
                'id_jadwal' => ('JI010125A1'),
                'jenis_ibadah' => ('Sunday Service'),
                'tgl_ibadah' => now(),
            ]
        );
    }
}
