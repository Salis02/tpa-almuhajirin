<?php

namespace Database\Factories;

use App\Models\Santri;
use App\Models\TpaClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class SantriFactory extends Factory
{
    protected $model = Santri::class;

    public function definition(): array
    {
        $gender = $this->faker->randomElement(['L', 'P']);

        return [
            'nis' => 'NIS' . date('Y') . str_pad($this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'full_name' => $this->faker->name($gender === 'L' ? 'male' : 'female'),
            'nickname' => $this->faker->firstName($gender === 'L' ? 'male' : 'female'),
            'gender' => $gender,
            'birth_date' => $this->faker->dateTimeBetween('-15 years', '-7 years')->format('Y-m-d'),
            'birth_place' => $this->faker->city,
            'address' => $this->faker->address,
            'phone' => $this->faker->optional()->phoneNumber,
            'photo_path' => null,
            'father_name' => $this->faker->name('male'),
            'mother_name' => $this->faker->name('female'),
            'guardian_name' => $this->faker->optional()->name,
            'guardian_phone' => $this->faker->phoneNumber,
            'guardian_address' => $this->faker->optional()->address,
            'class_id' => TpaClass::inRandomOrder()->first()->id,
            'enrollment_date' => $this->faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['active', 'inactive', 'graduated']),
        ];
    }
}
