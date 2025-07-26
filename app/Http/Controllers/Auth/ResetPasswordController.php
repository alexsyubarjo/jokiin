<?php

namespace App\Http\Controllers\Auth;

use Helper;
use App\Models\User;
use App\Models\Website;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\UserPasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;
    protected $redirectTo = RouteServiceProvider::HOME;

    public function get()
    {
        $website = Helper::getWebsite();
        return view("auth.passwords.email", $website);
    }

    public function change($reset_token = null)
    {
        $website = Helper::getWebsite();

        $check_token = UserPasswordReset::where("token", $reset_token)->first();
        if ($check_token == false) {
            return redirect("ganti/password");
        }
        $data = array_merge($website, [
            "target" => $check_token,
        ]);

        return view("auth.passwords.reset", $data);
    }

    public function post(Request $request)
    {
        $user = User::where(
            "email",
            Helper::escape_input($request->email)
        )->first();
        $input_data = [
            "email" => Helper::escape_input($request->email),
            "token" => md5(
                Helper::escape_input($request->email) .
                    "-" .
                    $user->username .
                    "-" .
                    rand(1, 99999)
            ),
        ];
        $check_data = UserPasswordReset::where(
            "email",
            $input_data["email"]
        )->first();

        if ($check_data == false) {
            $insert_data = UserPasswordReset::create($input_data);
            if ($insert_data == false) {
                return redirect()
                    ->route("password.request")
                    ->with("error", "Terjadi Kesalahan.");
            }
        } else {
            $update_data = $check_data->update([
                "email" => $input_data["email"],
                "token" => $input_data["token"],
                "created_at" => now(),
            ]);
            if ($update_data == false) {
                return redirect()
                    ->route("password.request")
                    ->with("error", "Terjadi Kesalahan.");
            }
        }
        $email_details = [
            "content" => [
                "url" => url("ganti/password/change/" . $input_data["token"]),
                "token" => $input_data["token"],
            ],
            "receiver" => [
                "email" => $user->email,
                "name" => $user->name,
            ],
        ];
        $send_email = Helper::send_email(
            $email_details,
            "Atur Ulang Kata Sandi - " .
                Helper::website_config("main")->website_name .
                "",
            "user.mail.reset_password"
        );
        if ($send_email["result"] == true) {
            return redirect()
                ->route("password.request")
                ->with(
                    "success",
                    "Silahkan periksa Email anda untuk mengatur ulang kata sandi akun Anda."
                );
        } else {
            return redirect()
                ->route("password.request")
                ->with("error", "Terjadi kesalahan mengirim email.");
        }
    }

    public function post_pass(Request $request)
    {
        $request->validate(
            [
                "password" => "required|alpha_num|min:5|max:15",
                "confirm_password" => "required|same:password",
            ],
            [
                "password.required" => "Kolom password diperlukan.",
                "password.alpha_num" =>
                    "Kolom password hanya boleh berisi huruf dan angka.",
                "password.min" =>
                    "Kolom password minimal harus memiliki 5 karakter.",
                "password.max" =>
                    "Kolom password maksimal harus memiliki 15 karakter.",
                "confirm_password.required" =>
                    "Kolom konfirmasi password diperlukan.",
            ]
        );
        $input_data = [
            "password" => Hash::make($request->password),
        ];

        $update_data = User::where("email", $request->email)->update(
            $input_data
        );
        if ($update_data == true) {
            $delete_data = UserPasswordReset::where(
                "email",
                $request->email
            )->delete();
            return redirect()
                ->route("login")
                ->with("success", "Password berhasil diatur ulang.");
        } else {
            return redirect()
                ->route("login")
                ->with("error", "Terjadi kesalahan.");
        }
    }
}
