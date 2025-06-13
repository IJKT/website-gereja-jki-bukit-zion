<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\jadwal_ibadah;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
                'tgl_ibadah' => Carbon::create(2025, 6, 8, 9, 0, 0),
            ]
        );
    }
}
