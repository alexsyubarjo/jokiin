<?php

namespace App\Http\Controllers\Auth;

use Helper;
use App\Models\User;
use App\Models\Referral;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\UserActivateAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware("guest")->except("logout");
    }

    public function showRegistrationForm()
    {
        //get home
        $data = Helper::getWebsite();

        //render view with home
        return view("auth.register", $data);
    }

    public function register(Request $request)
    {
        $request->validate(
            [
                "name" => "required|string|min:5|max:255",
                "username" => "required|string|min:5|max:255|unique:users",
                "email" => "required|string|email|max:255|unique:users",
                "password" => "required|string|min:6|confirmed",
                "terms" => "accepted",
            ],
            [
                "name.required" => "Kolom nama harus diisi.",
                "username.required" => "Kolom username harus diisi.",
                "username.unique" => "Username sudah digunakan.",
                "email.required" => "Kolom email harus diisi.",
                "email.email" => "Email harus berupa alamat email yang valid.",
                "email.unique" => "Email sudah digunakan.",
                "password.required" => "Kolom password harus diisi.",
                "password.min" =>
                    "Password minimal harus terdiri dari 8 karakter.",
                "password.confirmed" => "Konfirmasi password tidak sesuai.",
                "terms.accepted" =>
                    "Anda harus menyetujui syarat dan ketentuan.",
            ]
        );

        try {
            $referralCode = Session::get("referral_code");

            $referral = Str::random(8);
            while (User::where("kode_referral", $referral)->exists()) {
                $referral = Str::random(8);
            }
            $input_data = [
                "name" => $request->input("name"),
                "username" => $request->input("username"),
                "email" => $request->input("email"),
                "password" => Hash::make($request->input("password")),
                "kode_referral" => $referral,
                "active_status" => "1",
            ];
            if (Helper::website_config("smtp")->email_aktivasi == "") {
                $input_data["email_verified_at"] = Carbon::now();
            } else {
                $input_data["email_verified_at"] = null;
            }

            $insert_data = User::create($input_data);

            if ($referralCode) {
                $user_reff = Referral::where(
                    "user_id",
                    $insert_data->id
                )->first();
                if (!$user_reff) {
                    Referral::create([
                        "user_id" => $insert_data->id,
                        "referral" => $referralCode,
                    ]);
                }
                Session::forget("referral_code");
            }

            if ($input_data["email_verified_at"] == null) {
                $input_data["token"] = md5(
                    $input_data["email"] .
                        "-" .
                        $input_data["username"] .
                        "-" .
                        rand(1, 99999)
                );

                $insert_data = UserActivateAccount::create([
                    "email" => $input_data["email"],
                    "token" => $input_data["token"],
                ]);

                $email_details = [
                    "content" => [
                        "url" => url("auth/activate/" . $input_data["token"]),
                        "token" => $input_data["token"],
                    ],
                    "receiver" => [
                        "email" => $input_data["email"],
                        "name" => $input_data["name"],
                    ],
                ];

                // Kirim email verifikasi
                $send_email = Helper::send_email(
                    $email_details,
                    "Aktivasi Akun - " .
                        Helper::website_config("main")->website_name,
                    "user.mail.activate"
                );

                if ($send_email["result"] == true) {
                    return redirect()
                        ->route("login")
                        ->with(
                            "success",
                            "Registrasi berhasil, Silahkan periksa Email anda untuk mengaktifkan akun Anda."
                        );
                } else {
                    return redirect()
                        ->route("login")
                        ->with("error", "Terjadi kesalahan mengirim email.");
                }
            }
            if (Helper::website_config("smtp")->email_aktivasi == "") {
                return redirect()
                    ->route("login")
                    ->with("success", "Registrasi berhasil, Silahkan masuk.");
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors("Gagal melakukan registrasi, Silakan coba lagi.");
        }
    }
}
