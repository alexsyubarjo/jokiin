<?php

namespace App\Models;

use App\Models\User;
use App\Models\DataRepot;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function category()
    {
        return $this->belongsTo(Categories::class, "category_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function data_repot()
    {
        return $this->hasMany(DataRepot::class, "post_id");
    }
}
