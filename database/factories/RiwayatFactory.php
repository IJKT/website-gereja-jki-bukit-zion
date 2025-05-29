<?php

namespace Database\Factories;

use App\Models\Pelayan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RiwayatFactory extends Factory
{
    /**
     * Tracks the current suffix (letter and number) for each date to ensure unique id_log values.
     *
     * @var array<string, array{letter: string, number: int}>
     */
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
        $id_log = "RI{$datePart}{$suffix}";

        $pelayan = Pelayan::query()->first() ?? Pelayan::factory()->create();

        return [
            'id_log' => $id_log,
            'id_pelayan_creator' => $pelayan->id_pelayan,
            'jenis_perubahan' => $this->faker->randomElement(['Create', 'Update', 'Delete']),
            'tgl_perubahan' => $tgl_daftar
        ];
    }
}
