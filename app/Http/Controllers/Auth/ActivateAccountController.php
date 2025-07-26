<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserActivateAccount;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ActivateAccountController extends Controller
{
    public function activate(UserActivateAccount $target)
    {
        $user = User::where("email", $target->email)->update([
            "email_verified_at" => Carbon::now(),
        ]);
        $target->delete();
        return redirect()
            ->route("login")
            ->with("success", "Akun berhasil diaktifkan.");
    }
}
