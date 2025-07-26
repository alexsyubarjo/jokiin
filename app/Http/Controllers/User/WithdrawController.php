<?php

namespace App\Http\Controllers\User;

use Helper;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        // $rek = $user ? json_decode($user->rekening, false) : null;
        $rek = $user ? json_decode($user["user"]->rekening, false) : null;

        $data = array_merge($user, $website);
        if (!is_null($rek)) {
            $data["rek"] = $rek;
        }

        return view("user.withdraw", $data);
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();
        $website = Helper::getWebsite();

        //validate form
        $this->validate($request, [
            "jumlah" => "required",
        ]);

        $jum = str_replace(".", "", $request->input("jumlah"));

        $user = User::find($user_id);
        $log_saldo = Withdraw::where("user_id", 11)
            ->where("status", "Pending")
            ->get();

        if ($user->saldo === null) {
            return redirect()
                ->back()
                ->with("error", "Maaf saldo anda kosong.");
        } elseif ($jum < $website["web"]->min_wd) {
            $min_wd = number_format($website["web"]->min_wd, 0, ",", ".");
            return redirect()
                ->back()
                ->with(
                    "error",
                    "Jumlah minimal penarikan adalah <b>" . $min_wd . "</b>"
                );
        } elseif ($user->saldo < $jum) {
            return redirect()
                ->back()
                ->with(
                    "error",
                    "Maaf saldo anda tidak cukup untuk melakukan penarikan."
                );
        } elseif ($log_saldo->isNotEmpty()) {
            return redirect("dashboard/riwayat-penarikan")->with(
                "error",
                "Masih ada riwayat penarikan yang berstatus pending."
            );
        } else {
            $saldo = $user->saldo - $jum;

            $user->saldo = $saldo;
            $user->save();

            Withdraw::create([
                "user_id" => $user_id,
                "nominal" => $jum,
                "status" => "Pending",
            ]);
        }

        return redirect("dashboard/riwayat-penarikan")->with(
            "success",
            "Penarikan berhasil silahkan menunggu konfirmasi."
        );
    }
}
