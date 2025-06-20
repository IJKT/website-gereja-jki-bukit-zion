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
        $pelayan = [
            ['id_pelayan' => 'PL010125A1', 'id_jemaat' => 'JM010125A1', 'hak_akses' => 'Administrator'],
            ['id_pelayan' => 'PL010125A2', 'id_jemaat' => 'JM010125A2', 'hak_akses' => 'Multimedia'],
            ['id_pelayan' => 'PL010125A3', 'id_jemaat' => 'JM010125A3', 'hak_akses' => 'Koordinator'],
            ['id_pelayan' => 'PL010125A4', 'id_jemaat' => 'JM010125A4', 'hak_akses' => 'Praise & Worship'],
            ['id_pelayan' => 'PL010125A5', 'id_jemaat' => 'JM010125A5', 'hak_akses' => 'Bendahara'],
            ['id_pelayan' => 'PL010125A6', 'id_jemaat' => 'JM010125A6', 'hak_akses' => 'Pelayan Gereja'],
        ];
        foreach ($pelayan as $data) {
            Pelayan::updateOrCreate(
                ['id_pelayan' => $data['id_pelayan']],
                [
                    'id_jemaat' => $data['id_jemaat'],
                    'hak_akses_pelayan' => $data['hak_akses'],
                ]
            );
        }
        // Pelayan::updateOrCreate(
        //     ['id_pelayan' => 'PL010125A1'],
        //     [
        //         'id_jemaat' => 'JM010125A3',
        //         '' => 'Pelayan Gereja'
        //     ]
        // );
        // Pelayan::updateOrCreate(
        //     ['id_pelayan' => 'PL010125A2'],
        //     [
        //         'id_jemaat' => 'JM010125A4',
        //         'hak_akses_pelayan' => 'Multimedia'
        //     ]
        // );
        // Pelayan::updateOrCreate(
        //     ['id_pelayan' => 'PL010125A3'],
        //     [
        //         'id_jemaat' => 'JM010125A5',
        //         'hak_akses_pelayan' => 'Multimedia'
        //     ]
        // );
        // Pelayan::updateOrCreate(
        //     ['id_pelayan' => 'PL010125A4'],
        //     [
        //         'id_jemaat' => 'JM010125A6',
        //         'hak_akses_pelayan' => 'Praise & Worship'
        //     ]
        // );
    }
}
