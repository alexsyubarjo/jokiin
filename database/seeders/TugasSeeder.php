<?php

namespace Database\Seeders;

use App\Models\Tugas;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tugas::create([
            "user_id" => 11,
            "post_id" => 1,
            "comments" => "Contoh coment",
            "bukti" =>
                '{"proof1":"test1.jpg","proof2":"test2.jpg","proof3":"test3.jpg"}',
            "status" => 1,
        ]);
        Tugas::create([
            "user_id" => 11,
            "post_id" => 2,
            "comments" => "Contoh coment",
            "bukti" =>
                '{"proof1":"test1.jpg","proof2":"test2.jpg","proof3":"test3.jpg"}',
            "status" => 1,
        ]);
        Tugas::create([
            "user_id" => 11,
            "post_id" => 3,
            "comments" => "Contoh coment",
            "bukti" =>
                '{"proof1":"test1.jpg","proof2":"test2.jpg","proof3":"test3.jpg"}',
            "status" => 1,
        ]);
        Tugas::create([
            "user_id" => 11,
            "post_id" => 4,
            "comments" => "Contoh coment",
            "bukti" =>
                '{"proof1":"test1.jpg","proof2":"test2.jpg","proof3":"test3.jpg"}',
            "status" => 1,
        ]);
        Tugas::create([
            "user_id" => 11,
            "post_id" => 5,
            "comments" => "Contoh coment",
            "bukti" =>
                '{"proof1":"test1.jpg","proof2":"test2.jpg","proof3":"test3.jpg"}',
            "status" => 1,
        ]);
        Tugas::create([
            "user_id" => 11,
            "post_id" => 6,
            "comments" => "Contoh coment",
            "bukti" =>
                '{"proof1":"test1.jpg","proof2":"test2.jpg","proof3":"test3.jpg"}',
            "status" => 1,
        ]);
        Tugas::create([
            "user_id" => 11,
            "post_id" => 7,
            "comments" => "Contoh coment",
            "bukti" =>
                '{"proof1":"test1.jpg","proof2":"test2.jpg","proof3":"test3.jpg"}',
            "status" => 2,
        ]);
        Tugas::create([
            "user_id" => 11,
            "post_id" => 8,
            "comments" => "Contoh coment",
            "bukti" =>
                '{"proof1":"test1.jpg","proof2":"test2.jpg","proof3":"test3.jpg"}',
            "status" => 2,
        ]);
        Tugas::create([
            "user_id" => 11,
            "post_id" => 9,
            "comments" => "Contoh coment",
            "bukti" =>
                '{"proof1":"test1.jpg","proof2":"test2.jpg","proof3":"test3.jpg"}',
            "status" => 3,
        ]);
        Tugas::create([
            "user_id" => 11,
            "post_id" => 10,
            "comments" => "Contoh coment",
            "bukti" =>
                '{"proof1":"test1.jpg","proof2":"test2.jpg","proof3":"test3.jpg"}',
            "status" => 3,
        ]);
        Tugas::create([
            "user_id" => 11,
            "post_id" => 11,
            "comments" => "Contoh coment",
            "bukti" =>
                '{"proof1":"test1.jpg","proof2":"test2.jpg","proof3":"test3.jpg"}',
            "status" => 3,
        ]);
    }
}
