<?php

namespace App\Http\Controllers\User;

use Helper;
use App\Models\Deposit;
use App\Models\DataBank;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class DepositSaldoController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $bank = DataBank::get();
        // Merge user and website data into a single array
        $data = array_merge($user, $website, [
            "bank" => $bank,
        ]);
        // Pass the RiwayatSaldo data to the view
        return view("user.employer.deposit", $data);
    }

    public function riwayat_deposit()
    {
        $user_id = Auth::id();
        $user = Helper::getUserAuth();

        // Get additional data, such as website information, using the Helper method
        $website = Helper::getWebsite();

        // Merge user and website data into a single array
        $data = array_merge($user, $website);

        // Retrieve RiwayatSaldo data from the database
        $riwayatSaldo = Deposit::where("user_id", $user_id)
            ->latest("created_at")
            ->paginate(5);

        // Pass the RiwayatSaldo data to the view
        return view(
            "user.employer.riwayat-deposit",
            compact("riwayatSaldo")
        )->with($data);
    }

    public function deposit_manual(Request $request)
    {
        $request->validate(
            [
                "bank" => "required",
                "jumlah" => "required",
            ],
            [
                "bank.required" => "Kolom Tujuan deposit wajib diisi.",
                "jumlah.required" => "Kolom Nominal deposit wajib diisi.",
            ]
        );

        $user_id = Auth::id();
        $bank = $request->input("bank");
        $jumlah = $request->input("jumlah");
        $kode = time() . $user_id;

        $cek = Deposit::where("user_id", $user_id)
            ->where("status", "Pending")
            ->get();

        if ($cek->count() > 0) {
            return redirect("dashboard/riwayat-deposit")->with(
                "warning",
                "Masih terdapat deposit yang berstatus pending"
            );
        } else {
            Deposit::create([
                "kode" => $kode,
                "user_id" => $user_id,
                "nominal" => $jumlah,
                "bank" => $bank,
                "metode" => "Manual",
                "status" => "Pending",
            ]);

            return redirect(
                "dashboard/invoice-deposit?inv=" . Crypt::encrypt($kode)
            )->with("success", "Berhasil Membuat Deposit.");
        }
    }

    public function batal_deposit(Request $request)
    {
        $kode = $request->input("inv");
        $user_id = Auth::id();

        $depo = Deposit::where("kode", $kode)->first();

        $depo->update([
            "status" => "Cancel",
        ]);

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }

    public function InvoiceDeposit(Request $request)
    {
        $kode = $request->input("inv");
        try {
            $kode = Crypt::decrypt($kode);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect("dashboard/riwayat-deposit")->with(
                "warning",
                "Invoice tidak di ketahui."
            );
        }

        $user_id = Auth::id();
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $deposit = Deposit::where("kode", $kode)->first();

        if ($deposit && $deposit->bank) {
            $b = DataBank::where("key", $deposit->bank)->first();
            $daBank = $b ? json_decode($b->value, false) : null;

            $data = array_merge($user, $website, [
                "depo" => $deposit,
                "bank" => $daBank,
            ]);
            return view("user.employer.invoice-deposit", $data);
        } else {
            return redirect("dashboard/riwayat-deposit")->with(
                "warning",
                "Invoice tidak di ketahui."
            );
        }
    }

    public function AjaxDeposit(Request $request)
    {
        $user_id = Auth::id();

        $riwayatSaldo = Deposit::where("user_id", $user_id)
            ->latest("created_at")
            ->paginate(5);

        $partialView = view(
            "user.partial.riwayat-deposit",
            compact("riwayatSaldo")
        )->render();

        return response()->json([
            "partialView" => $partialView,
        ]);
    }
}
