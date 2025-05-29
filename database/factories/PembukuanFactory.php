<?php

namespace Database\Factories;

use App\Models\Pembukuan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pembukuan>
 */
class PembukuanFactory extends Factory
{

    protected static array $suffixTracker = [];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tgl_daftar = now();
        $datePart = $tgl_daftar->format('dmy');

        // Initialize or increment suffix for this date
        $tracker = &self::$suffixTracker[$datePart];
        if (!isset($tracker)) {
            $tracker = ['letter' => 'A', 'number' => 1];
        } elseif ($tracker['number'] < 9) {
            $tracker['number']++;
        } else {
            $tracker['number'] = 1;
            $tracker['letter'] = chr(ord($tracker['letter']) + 1);
        }

        $suffix = $tracker['letter'] . $tracker['number'];
        $id_pembukuan = "PG{$datePart}{$suffix}";
        $verifikasi = fake()->numberBetween(0, 2);
        $catatan = null;
        if ($verifikasi == 2) {
            $catatan = fake()->text(20);
        }

        return [
            'id_pembukuan' => $id_pembukuan,
            'jenis_pembukuan' => fake()->randomElement(['Uang Masuk', 'Uang Keluar']),
            'nominal_pembukuan' => fake()->numberBetween($min = 10000, $max = 100000000),
            'tgl_pembukuan' => $tgl_daftar,
            'deskripsi_pembukuan' => fake()->text(20),
            'verifikasi_pembukuan' => $verifikasi,
            'catatan_pembukuan' => $catatan
        ];
    }
}
