<?php

namespace Database\Seeders;

use App\Models\lagu_pujian;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            JemaatSeeder::class,
            PelayanSeeder::class,
            PengajuanSeeder::class,
            BaptisSeeder::class,
            PernikahanSeeder::class,
            JadwalIbadahSeeder::class,
            DetailJadwalSeeder::class,
            LaguPujianSeeder::class,
            DetailLaguPujianSeeder::class,
            RangkumanFirmanSeeder::class,
        ]);
    }
}
