<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absensi>
 */
class AbsensiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => fake()->numberBetween(1, 50),
            'tanggal' => fake()->date(),
            'absen_masuk' => fake()->time(),
            'keterangan_absen_masuk' => fake()->sentence(), 
            'status_absen_masuk' => fake()->randomElement(['Hadir', 'Absen']),
            'absen_pulang' => fake()->time(),
            'keterangan_absen_pulang' => fake()->sentence(),
            'status_absen_pulang' => fake()->randomElement(['Hadir', 'Absen']),
            'keterlambatan_absen_masuk' => fake()->date(),
            'keterlambatan_absen_pulang' => fake()->date(),
        ];
    }
}
