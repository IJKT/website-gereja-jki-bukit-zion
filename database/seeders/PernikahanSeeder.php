<?php

namespace Database\Seeders;

use App\Models\Pernikahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PernikahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pernikahan::updateOrCreate(
            [
                'id_pernikahan' => 'PJ010125A2',
                'id_jemaat_p' => 'JM180903A1',
                'id_jemaat_w' => 'JM010125A1',
                'id_pendeta' => 'PL010125A1',
                'tgl_pernikahan' => now(),
            ]
        );
    }
}
