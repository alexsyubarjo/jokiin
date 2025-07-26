<?php

namespace App\Http\Controllers\Admin;

use Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SettingAkun extends Controller
{
    public function __construct()
    {
        $this->middleware("adminMiddle");
    }

    public function index()
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $data = array_merge($user, $website, [
            "page" => "Setting Akun",
        ]);

        return view("admin.setting-akun", $data);
    }

    public function update(Request $request)
    {
        $user = Helper::getAdminAuth();

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email," . $user["user"]->id,
        ]);

        $user["user"]->name = $request->input("name");
        $user["user"]->email = $request->input("email");
        $user["user"]->save();

        return redirect("admin/setting-akun")->with(
            "success",
            "Profile updated successfully"
        );
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            "password" => "required",
            "password-baru" => "required|min:3",
        ]);

        $user = Helper::getAdminAuth();

        if (
            !Hash::check($request->input("password"), $user["user"]->password)
        ) {
            return back()->with(
                "errors",
                "Password saat ini tidak cocok dengan data kami."
            );
        }

        $user["user"]->password = Hash::make($request->input("password-baru"));
        $user["user"]->save();

        return redirect()
            ->back()
            ->with("success", "Password berhasil diubah.");
    }
}
