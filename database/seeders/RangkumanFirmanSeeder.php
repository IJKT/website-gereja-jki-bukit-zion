<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\rangkuman_firman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RangkumanFirmanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $judul1 = Str::title(Str::limit(fake()->sentence(), 50));
        $judul2 = Str::title(Str::limit(fake()->sentence(), 50));
        $judul3 = Str::title(Str::limit(fake()->sentence(), 50));

        rangkuman_firman::updateOrCreate(
            ['id_rangkuman_firman' => 'RF010125A1'],
            [
                'id_pelayan_pnl' => 'PL180903A1',
                'nama_narasumber' => fake()->name(),
                'judul_rangkuman' => $judul1,
                'tgl_rangkuman' => now(),
                'slug_rangkuman' => Str::slug($judul1),
                'isi_rangkuman' => fake()->paragraph(),
                'tipe_rangkuman' => 'Sermons',
                'kategori_sermons' => 'Sunday Service',
            ]
        );
        rangkuman_firman::updateOrCreate(
            ['id_rangkuman_firman' => 'RF010125A2'],
            [
                'id_pelayan_pnl' => 'PL180903A1',
                'nama_narasumber' => fake()->name(),
                'judul_rangkuman' => $judul2,
                'tgl_rangkuman' => now(),
                'slug_rangkuman' => Str::slug($judul2),
                'isi_rangkuman' => fake()->paragraph(),
                'tipe_rangkuman' => 'Articles',
            ]
        );
        rangkuman_firman::updateOrCreate(
            ['id_rangkuman_firman' => 'RF010125A3'],
            [
                'id_pelayan_pnl' => 'PL180903A1',
                'nama_narasumber' => fake()->name(),
                'judul_rangkuman' => $judul3,
                'tgl_rangkuman' => now(),
                'slug_rangkuman' => Str::slug($judul3),
                'isi_rangkuman' => fake()->paragraph(),
                'tipe_rangkuman' => 'Devotions',
            ]
        );
    }
}
