<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            "category_id" => rand(1, 5), // Ganti 5 dengan jumlah Categories yang ada
            "user_id" => 11, // Ganti 5 dengan jumlah Categories yang ada
            "image" => $this->faker->imageUrl(),
            "title" => $this->faker->sentence,
            "slug" => Str::slug($this->faker->unique()->word),
            "content" => $this->faker->paragraph,
            "jumlah" => $this->faker->numberBetween($min = 20, $max = 200),
            "komisi" => $this->faker->numberBetween($min = 1000, $max = 10000),
            "nama_file_form" => '{"proof1":"File Bukti"}',
        ];
    }
}
