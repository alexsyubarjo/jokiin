<?php

namespace Database\Seeders;

use App\Models\Logs;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Logs::create([
            "user_id" => 11,
            "log_info" =>
                "Tugas anda <b>Contoh tugas saja</b> di tolak Employer.",
            "status" => "Error",
        ]);

        Logs::create([
            "user_id" => 11,
            "log_info" =>
                "Kamu mendapatkan <b>2.000</b> dari Tugas <b>Contoh tugas saja</b>",
            "status" => "Sukses",
        ]);
    }
}
