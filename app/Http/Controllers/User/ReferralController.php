<?php

namespace App\Http\Controllers\User;

use Helper;
use App\Models\User;
use App\Models\Referral;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $reff = Referral::with("user")
            ->where("referral", $user["user"]->kode_referral)
            ->orderBy("id", "desc")
            ->paginate(5);

        $data = array_merge($user, $website, [
            "dataReff" => $reff,
        ]);

        return view("user.referral", $data);
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $newReferralCode = $request->input("referral");

        // Check if the new referral code is unique
        if ($newReferralCode != $user->kode_referral) {
            $existingUser = User::where(
                "kode_referral",
                $newReferralCode
            )->first();
            if (!$existingUser) {
                Referral::where("referral", $user->kode_referral)->update([
                    "referral" => $newReferralCode,
                ]);

                $user->kode_referral = $newReferralCode;
                $user->save();

                return redirect()
                    ->back()
                    ->with("success", "Referral berhasil diubah.");
            } else {
                return redirect()
                    ->back()
                    ->with(
                        "error",
                        "Kode referral sudah digunakan oleh pengguna lain."
                    );
            }
        } else {
            return redirect()
                ->back()
                ->with(
                    "error",
                    "Kode referral baru harus berbeda dari kode referral saat ini."
                );
        }
    }

    public function AjaxReff(Request $request)
    {
        $user = Helper::getUserAuth();

        $dataReff = Referral::with("user")
            ->where("referral", $user["user"]->kode_referral)
            ->orderBy("id", "desc")
            ->paginate(5);

        $partialView = view(
            "user.partial.referral-load",
            compact("dataReff")
        )->render();

        return response()->json([
            "partialView" => $partialView,
        ]);
    }
}
