<?php

namespace App\Http\Controllers\User;

use Helper;
use App\Models\Bank;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RekeningController extends Controller
{
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
        $data["bank"] = Bank::where("type", "bank")->get();
        $data["emoney"] = Bank::where("type", "emoney")->get();

        return view("user.rekening", $data);
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();
        // Validasi data yang diterima dari form
        $request->validate(
            [
                "bank" => "required",
                "nama" => "required",
                "rek" => "required",
            ],
            [
                "bank.required" => "Kolom Bank wajib diisi.",
                "nama.required" => "Kolom Nama Rekening wajib diisi.",
                "rek.required" => "Kolom Nomor Rekening wajib diisi.",
            ]
        );

        $rek["bank"] = $request->input("bank");
        $rek["nama"] = $request->input("nama");
        $rek["rek"] = $request->input("rek");

        $rekening = json_encode($rek, JSON_UNESCAPED_SLASHES);
        // Simpan pesan baru
        $user = User::find($user_id);

        if ($user->rekening === null) {
            $user->update([
                "rekening" => $rekening,
            ]);
        } else {
            $user->rekening = $rekening;
            $user->save();
        }

        return redirect()
            ->back()
            ->with("success", "Rekening berhasil diupdate.");
    }
}
