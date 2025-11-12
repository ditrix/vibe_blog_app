<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->withoutTwoFactor()
            ->create([
                'name' => 'Администратор',
                'email' => 'admin@mail.com',
                'password' => 'password',
                'email_verified_at' => now(),
            ]);

        $this->call(PostSeeder::class);
    }
}
