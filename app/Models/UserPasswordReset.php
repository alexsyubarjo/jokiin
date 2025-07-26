<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPasswordReset extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "user_password_resets";
    protected $guarded = ["id"];
}
