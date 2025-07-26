<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CallbackController extends Controller
{
    public function handleCallbackDuitku(Request $request)
    {
        $p = Website::where("key", "duitku_payment")->first();
        $pay = $p ? json_decode($p->value, false) : null;

        $apiKey = $pay->api_key;
        $merchantCode = $request->input("merchantCode");
        $amount = $request->input("amount");
        $merchantOrderId = $request->input("merchantOrderId");
        $productDetail = $request->input("productDetail");
        $additionalParam = $request->input("additionalParam");
        $paymentCode = $request->input("paymentCode");
        $resultCode = $request->input("resultCode");
        $merchantUserId = $request->input("merchantUserId");
        $reference = $request->input("reference");
        $signature = $request->input("signature");
        $publisherOrderId = $request->input("publisherOrderId");

        if (
            !empty($merchantCode) &&
            !empty($amount) &&
            !empty($merchantOrderId) &&
            !empty($signature)
        ) {
            $params = $merchantCode . $amount . $merchantOrderId . $apiKey;
            $calcSignature = md5($params);

            if ($resultCode == "00") {
                $status = "Sukses";
            } elseif ($resultCode == "01") {
                $status = "Pending";
            } elseif ($resultCode == "02") {
                $status = "Cancel";
            }
            $data = Deposit::where("kode", $merchantOrderId)->first();

            if ($signature == $calcSignature) {
                if ($data) {
                    if ($resultCode == "00") {
                        $data->update([
                            "status" => "Sukses",
                        ]);

                        $user = User::where("id", $data->user_id)->first();

                        $user->update([
                            "saldo_employer" => $user->saldo_employer + $amount,
                        ]);
                    } elseif ($resultCode == "01") {
                        $data->update([
                            "status" => "Pending",
                        ]);
                    } elseif ($resultCode == "02") {
                        $data->update([
                            "status" => "Cancel",
                        ]);
                    }
                }

                return response()->json(["success" => true], 200);
            } else {
                // Log callback untuk debug
                // file_put_contents('callback.txt', "* Bad Signature *\r\n\r\n", FILE_APPEND | LOCK_EX);

                throw new Exception("Bad Signature");
            }
        } else {
            // Log callback untuk debug
            // file_put_contents('callback.txt', "* Bad Parameter *\r\n\r\n", FILE_APPEND | LOCK_EX);

            throw new Exception("Bad Parameter");
        }
    }
}
