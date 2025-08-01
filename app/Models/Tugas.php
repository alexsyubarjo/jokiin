<?php

namespace App\Models;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function post()
    {
        return $this->belongsTo(Post::class, "post_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
