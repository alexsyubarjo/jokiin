<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bank::create([
            "bank" => "BRI",
            "nama_bank" => "Bank Rakyat Indonesia",
            "type" => "bank",
        ]);

        Bank::create([
            "bank" => "BCA",
            "nama_bank" => "Bank Central Asia",
            "type" => "bank",
        ]);

        Bank::create([
            "bank" => "Mandiri",
            "nama_bank" => "Bank Mandiri",
            "type" => "bank",
        ]);

        Bank::create([
            "bank" => "BNI",
            "nama_bank" => "Bank Negara Indonesia",
            "type" => "bank",
        ]);

        Bank::create([
            "bank" => "CIMB",
            "nama_bank" => "CIMB Niaga",
            "type" => "bank",
        ]);

        Bank::create([
            "bank" => "Danamon",
            "nama_bank" => "Bank Danamon",
            "type" => "bank",
        ]);

        Bank::create([
            "bank" => "Permata",
            "nama_bank" => "Bank Permata",
            "type" => "bank",
        ]);

        Bank::create([
            "bank" => "DANA",
            "nama_bank" => "Dana",
            "type" => "emoney",
        ]);

        Bank::create([
            "bank" => "OVO",
            "nama_bank" => "OVO",
            "type" => "emoney",
        ]);

        Bank::create([
            "bank" => "GoPay",
            "nama_bank" => "GoPay",
            "type" => "emoney",
        ]);

        Bank::create([
            "bank" => "LinkAja",
            "nama_bank" => "LinkAja",
            "type" => "emoney",
        ]);

        Bank::create([
            "bank" => "ShopeePay",
            "nama_bank" => "ShopeePay",
            "type" => "emoney",
        ]);

        Bank::create([
            "bank" => "Gopay",
            "nama_bank" => "Gopay",
            "type" => "emoney",
        ]);

        Bank::create([
            "bank" => "Doku",
            "nama_bank" => "Doku",
            "type" => "emoney",
        ]);
    }
}
