<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;
use Helper;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware("guest")->except("logout");
    }

    public function showLoginForm()
    {
        //get home
        $data = Helper::getWebsite();

        //render view with home
        return view("auth.login", $data);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $request
            ->session()
            ->flash("errors", "Email, Username atau password kamu salah!");

        return redirect(route("login"));
    }

    public function username()
    {
        $login = request()->input("username");
        $field = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? "email"
            : "username";
        request()->merge([$field => $login]);
        return $field;
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->email_verified_at && $user->email_verified_at === null) {
            // Set flash message indicating inactive account
            Session::flash(
                "errors",
                "Silahkan Verifikasi Akun Terlebih Dahulu!"
            );

            // Logout the user
            Auth::logout();

            // Redirect back to the login page
            return redirect(route("login"));
        } elseif ($user->active_status !== 1 && $user->active_status !== "1") {
            // Set flash message indicating inactive account
            Session::flash("errors", "Akun Kamu Tidak aktif!");

            // Logout the user
            Auth::logout();

            // Redirect back to the login page
            return redirect(route("login"));
        }

        Session::flash(
            "success",
            "<b>Login Sukses!</b><br /><br /> Selamat datang di dashboard."
        );
        return redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        \Session::flush();
        return redirect(route("login"))->with(
            "success",
            "Anda berhasil keluar!"
        );
    }
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();

            $finduser = User::where("provider_id", $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);

                return redirect("/dashboard");
            } else {
                $newUser = User::create([
                    "name" => $user->name,
                    "email" => $user->email,
                    "provider" => $provider,
                    "provider_id" => $user->id,
                    "password" => encrypt("demo"),
                ]);

                Auth::login($newUser);

                return redirect("/dashboard");
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
