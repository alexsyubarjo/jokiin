<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            WebsiteSeeder::class,
            CategoriesSeeder::class,
            PostSeeder::class,
            TugasSeeder::class,
            LogsSeeder::class,
            BankSeeder::class,
            DataBankSeeder::class,
        ]);
    }
}
