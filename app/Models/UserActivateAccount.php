<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivateAccount extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "user_activate_accounts";
    protected $guarded = ["id"];
}
