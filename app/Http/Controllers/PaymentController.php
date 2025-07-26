<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function PayDuitku(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);

        $p = Website::where("key", "duitku_payment")->first();
        $pay = $p ? json_decode($p->value, false) : null;

        $amount = str_replace(".", "", $request->input("paymentAmount"));

        $merchantCode = $pay->merchant_code; // from duitku
        $merchantKey = $pay->api_key; // from duitku

        $paymentAmount = $amount;
        $email = $user->email;
        $phoneNumber = $user->nomor_hp;
        $productDetails = "Deposit Saldo";
        $merchantOrderId = time() . $user->id; // from merchant, unique
        $additionalParam = ""; // optional
        $merchantUserInfo = ""; // optional
        $customerVaName = $user->name; // display name on bank confirmation display
        $callbackUrl = env("DUITKU_CALLBACL_URL"); // url for callback
        $returnUrl = env("DUITKU_RETURN_URL"); // url for redirect
        $expiryPeriod = 24; // set the expired time in minutes

        $cek = Deposit::where("user_id", $user_id)
            ->where("status", "Pending")
            ->get();

        if ($cek->count() > 0) {
            return response()->json("masih_pending");
        } else {
            $customerDetail = [
                "firstName" => $user->name,
                "email" => $email,
                "phoneNumber" => $phoneNumber,
            ];

            $item1 = [
                "name" => "Deposit",
                "price" => (int) $paymentAmount,
            ];

            $itemDetails = [$item1];

            $params = [
                "merchantCode" => $merchantCode,
                "paymentAmount" => (int) $paymentAmount,
                "merchantOrderId" => (string) $merchantOrderId,
                "productDetails" => $productDetails,
                "additionalParam" => $additionalParam,
                "merchantUserInfo" => $merchantUserInfo,
                "customerVaName" => $customerVaName,
                "email" => $email,
                "phoneNumber" => $phoneNumber,
                "itemDetails" => $itemDetails,
                "customerDetail" => $customerDetail,
                "callbackUrl" => $callbackUrl,
                "returnUrl" => $returnUrl,
                "expiryPeriod" => $expiryPeriod,
            ];

            $params_string = json_encode($params);

            if ($pay->mode == "Sanbox") {
                $url =
                    "https://api-sandbox.duitku.com/api/merchant/createInvoice";
            } elseif ($pay->mode == "Production") {
                $url = "https://api-prod.duitku.com/api/merchant/createInvoice";
            }

            $timestamp = round(microtime(true) * 1000);
            $signature = hash(
                "sha256",
                $merchantCode . $timestamp . $merchantKey
            );
            $headers = [
                "Content-Type" => "application/json",
                "Content-Length" => strlen($params_string),
                "x-duitku-signature" => $signature,
                "x-duitku-timestamp" => $timestamp,
                "x-duitku-merchantcode" => $merchantCode,
            ];

            $response = Http::withHeaders($headers)->post($url, $params);

            if ($response->status() == 200) {
                $result = $response->json();
                return response()->json($result); // Mengembalikan respons dalam format JSON
            } else {
                return response()->json(["error" => "An error occurred."]); // Mengembalikan respons error dalam format JSON
            }
        }
    }

    public function responDuitku(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);

        $kode = $request->input("kode");
        $status = $request->input("status");
        $amount = $request->input("amount");
        $ref = $request->input("reference");

        $data = Deposit::where("kode", $kode)->first();

        if ($status == "Pending") {
            if ($data) {
                $result = $result = $data->update([
                    "status" => $status,
                ]);
            } else {
                $result = Deposit::create([
                    "kode" => $kode,
                    "user_id" => $user_id,
                    "nominal" => $amount,
                    "bank" => $ref,
                    "metode" => "Otomatis",
                    "status" => $status,
                ]);
            }

            if ($result) {
                return response()->json(["status" => "Success"]);
            } else {
                return response()->json(["status" => "Error"]);
            }
        } elseif ($status == "Sukses") {
            $saldo = str_replace(".", "", $amount);
            if ($data) {
                $result = $data->update([
                    "status" => $status,
                ]);

                $user->update([
                    "saldo_employer" => $user->saldo_employer + $saldo,
                ]);
            } else {
                $result = Deposit::create([
                    "kode" => $kode,
                    "user_id" => $user_id,
                    "nominal" => $amount,
                    "bank" => $ref,
                    "metode" => "Otomatis",
                    "status" => $status,
                ]);
                $user->update([
                    "saldo_employer" => $user->saldo_employer + $saldo,
                ]);
            }

            if ($result) {
                return response()->json(["status" => "Success"]);
            } else {
                return response()->json(["status" => "Error"]);
            }
        } elseif ($status == "Error") {
            if ($data) {
                $result = $data->update([
                    "status" => $status,
                ]);
            } else {
                $result = Deposit::create([
                    "kode" => $kode,
                    "user_id" => $user_id,
                    "nominal" => $amount,
                    "bank" => $ref,
                    "metode" => "Otomatis",
                    "status" => $status,
                ]);
            }
            if ($result) {
                return response()->json(["status" => "Success"]);
            } else {
                return response()->json(["status" => "Error"]);
            }
        }
    }
}
