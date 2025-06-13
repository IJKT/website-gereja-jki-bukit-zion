<?php

namespace Database\Seeders;

use App\Models\PengajuanJemaat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PengajuanJemaat::updateOrCreate(
            ['id_pengajuan' => 'PJ010125A1'],
            [
                'id_jemaat' => 'JM180903A1',
                'jenis_pengajuan' => 'Baptis',
                'tanggal_pengajuan' => now(),
            ]
        );
        PengajuanJemaat::updateOrCreate(
            ['id_pengajuan' => 'PJ010125A2'],
            [
                'id_jemaat' => 'JM010125A1',
                'jenis_pengajuan' => 'Pernikahan',
                'tanggal_pengajuan' => now(),
            ]
        );
        // PengajuanJemaat::updateOrCreate(
        //     ['id_pengajuan' => 'PJ010125A3'],
        //     [
        //         'id_jemaat' => 'JM010125A2',
        //         'jenis_pengajuan' => 'Registrasi',
        //         'tanggal_pengajuan' => now(),
        //     ]
        // );
    }
}
