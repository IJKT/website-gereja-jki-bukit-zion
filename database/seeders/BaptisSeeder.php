<?php

namespace Database\Seeders;

use App\Models\Baptis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BaptisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Baptis::updateOrCreate(
            [
                'id_baptis' => 'PJ010125A1',
                'id_jemaat' => 'JM180903A1',
                'preferensi_nama_baptis' => 'Bahasa Indonesia',
                'id_pengajar' => 'PL010125A1',
            ]
        );
    }
}
