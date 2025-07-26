<?php

namespace Database\Seeders;

use App\Models\DataBank;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataBank::create([
            "key" => "BRI",
            "value" => '{"nama_rek":"Contoh BRI", "no_rek":"0123456789"}',
        ]);

        DataBank::create([
            "key" => "BCA",
            "value" => '{"nama_rek":"Contoh BCA", "no_rek":"0123456789"}',
        ]);

        DataBank::create([
            "key" => "Mandiri",
            "value" => '{"nama_rek":"Contoh Mandiri", "no_rek":"0123456789"}',
        ]);
    }
}
