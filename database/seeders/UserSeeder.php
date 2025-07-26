<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            "name" => "Test User",
            "username" => "demo",
            "email" => "demo@gmail.com",
            "username" => "demo",
            "password" => bcrypt("demo"),
            "rekening" =>
                '{"bank":"BRI", "nama":"Contoh Nama", "rek":"123456879123456"}',
            "active_status" => 1,
            "avatar" => "f109926b-7681-4c88-80a8-a26a27c60edf.png",
        ]);
    }
}
