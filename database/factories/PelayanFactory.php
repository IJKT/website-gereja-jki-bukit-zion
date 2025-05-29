<?php

namespace Database\Factories;

use App\Models\Jemaat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelayan>
 */
class PelayanFactory extends Factory
{
    /**
     * Static array to track the last suffix per date.
     * Format: [ 'dmy' => ['letter' => 'A', 'number' => 1] ]
     */
    protected static $suffixTracker = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a registration date
        $tgl_daftar = now();
        $datePart = $tgl_daftar->format('dmy');

        // Initialize or increment suffix for this date
        if (!isset(self::$suffixTracker[$datePart])) {
            self::$suffixTracker[$datePart] = ['letter' => 'A', 'number' => 1];
        } else {
            // Increment number, and if >9, increment letter and reset number
            if (self::$suffixTracker[$datePart]['number'] < 9) {
                self::$suffixTracker[$datePart]['number']++;
            } else {
                self::$suffixTracker[$datePart]['number'] = 1;
                self::$suffixTracker[$datePart]['letter'] = chr(ord(self::$suffixTracker[$datePart]['letter']) + 1);
            }
        }

        $letter = self::$suffixTracker[$datePart]['letter'];
        $number = self::$suffixTracker[$datePart]['number'];
        $suffix = $letter . $number;

        // Compose the id_pelayan
        $id_pelayan = "PL{$datePart}{$suffix}";

        // Find or create a Jemaat with hak_akses_jemaat = 'Pelayan' and no Pelayan yet
        $jemaat = Jemaat::where('hak_akses_jemaat', 'Pelayan')
            ->whereDoesntHave('pelayan')
            ->inRandomOrder()
            ->first() ?? Jemaat::factory()->create(['hak_akses_jemaat' => 'Pelayan']);

        return [
            'id_pelayan' => $id_pelayan,
            'id_jemaat' => $jemaat->id_jemaat,
            'hak_akses_pelayan' => $this->faker->randomElement([
                'Administrator',
                'Koordinator',
                'Bendahara',
                'Multimedia',
                'Praise & Worship',
                'Pelayan Gereja'
            ])
        ];
    }
}
