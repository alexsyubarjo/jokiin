<?php

namespace App\Http\Controllers\Admin\Auth;

use Auth;
use App\Models\Admin;
use Helper;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $guard = "adminMiddle";
    protected $redirectTo = "adminDashboard";

    public function __construct()
    {
        $this->middleware("guest")->except("logout");
    }

    public function guard(Request $request)
    {
        return \Illuminate\Support\Facades\Auth::guard("adminMiddle");
    }

    public function login()
    {
        if (
            auth()
                ->guard("adminMiddle")
                ->user()
        ) {
            return back();
        }

        //get home
        $website = Website::where("key", "main")->first();
        $soc = Website::where("key", "socials")->first();

        $data["web"] = json_decode($website->value, false);
        $data["soc"] = json_decode($soc->value, false);

        return view("auth.loginAdmin", $data);
    }

    public function loginForm(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email",
            "password" => "required",
        ]);

        $remember = $request->has("remember");

        if (
            auth()
                ->guard("adminMiddle")
                ->attempt(
                    [
                        "email" => $request->email,
                        "password" => $request->password,
                    ],
                    $remember
                )
        ) {
            $admin = auth()
                ->guard("adminMiddle")
                ->user();
            return redirect()
                ->route("adminDashboard")
                ->with("success", "Anda berhasil login!");
        } else {
            return back()->with("errors", "Email atau password kamu salah!");
        }
    }

    public function adminLogout(Request $request)
    {
        auth()
            ->guard("adminMiddle")
            ->logout();
        \Session::flush();
        return redirect(route("adminLogin"))->with(
            "success",
            "Anda berhasil keluar!"
        );
    }
}
