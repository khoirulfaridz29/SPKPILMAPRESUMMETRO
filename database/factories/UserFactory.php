<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username'     => fake()->unique()->userName(),
            'nama_lengkap' => fake()->name(),
            'password'     => Hash::make('Password1!'),
            'role'         => 'mahasiswa',
            'nidn'         => null,
        ];
    }

    public function admin(): static
    {
        return $this->state(['role' => 'admin']);
    }

    public function juri(): static
    {
        return $this->state(['role' => 'juri']);
    }

    public function wr3(): static
    {
        return $this->state(['role' => 'wr3']);
    }
}
