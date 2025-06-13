<?php

namespace Database\Seeders;

use App\Models\lagu_pujian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaguPujianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        lagu_pujian::updateOrCreate(
            ['id_lagu' => 'LI010125A1'],
            [
                'nama_lagu' => 'RohMu Yang Hidup',
                'link_lagu' => 'https://youtu.be/MwN82mxCwc8?si=z_mq_r7Qneqyv-ew'
            ]
        );
        lagu_pujian::updateOrCreate(
            ['id_lagu' => 'LI010125A2'],
            [
                'nama_lagu' => 'Anggur Baru',
                'link_lagu' => 'https://youtu.be/YIej_zkdy38?si=jPXBtPMDnk_yeu2x'
            ]
        );
        lagu_pujian::updateOrCreate(
            ['id_lagu' => 'LI010125A3'],
            [
                'nama_lagu' => 'Mengalirlah Kuasa Roh Kudus',
                'link_lagu' => 'https://youtu.be/4d7CbNBZD3E?si=COay7Yp3oH5aGMdY'
            ]
        );
        lagu_pujian::updateOrCreate(
            ['id_lagu' => 'LI010125A4'],
            [
                'nama_lagu' => 'Roh Kudus Datanglah',
                'link_lagu' => 'https://youtu.be/beLH0XPfygs?si=SRub8Kz6JPeXDwpw'
            ]
        );
        lagu_pujian::updateOrCreate(
            ['id_lagu' => 'LI020125A1'],
            [
                'nama_lagu' => 'Bersamamu Bapa',
                'link_lagu' => 'https://youtu.be/TCVzMfg5E9s?si=4qGe45-b4XMb47dc'
            ]
        );
        lagu_pujian::updateOrCreate(
            ['id_lagu' => 'LI020125A2'],
            [
                'nama_lagu' => 'Yeshuaku Kau Terindah',
                'link_lagu' => 'https://youtu.be/iq69wgxN0Bs?si=b6q48JtyAUnSG3o-'
            ]
        );
        lagu_pujian::updateOrCreate(
            ['id_lagu' => 'LI020125A3'],
            [
                'nama_lagu' => 'Ingat Kasih-Nya',
                'link_lagu' => 'https://youtu.be/Pq2N6Z9U6O0?si=ggsrvzKyhe53GFgW'
            ]
        );
    }
}
