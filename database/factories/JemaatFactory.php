<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jemaat>
 */
class JemaatFactory extends Factory
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

        // Compose the id_jemaat
        $id_jemaat = "JM{$datePart}{$suffix}";

        // Create a user and use its username
        $user = User::whereDoesntHave('jemaat')->inRandomOrder()->first() ?? User::factory()->create();
        return [
            'id_jemaat' => $id_jemaat,
            'username' => $user->username,
            'nama_jemaat' => $this->faker->name,
            'jk_jemaat' => $this->faker->randomElement(['P', 'W']),
            'nik_jemaat' => $this->faker->numerify('################'),
            'tmpt_lahir_jemaat' => $this->faker->city,
            'tgl_lahir_jemaat' => $this->faker->date(),
            'telp_jemaat' => $this->faker->phoneNumber,
            'tgl_daftar_jemaat' => $tgl_daftar,
            'email_jemaat' => $this->faker->unique()->safeEmail,
            'alamat_jemaat' => $this->faker->address,
            'hak_akses_jemaat' => 'Jemaat',
        ];
    }
}
