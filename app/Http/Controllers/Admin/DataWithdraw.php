<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Models\Logs;
use App\Models\User;
use App\Models\Referral;
use App\Models\Withdraw;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataWithdraw extends Controller
{
    public function __construct()
    {
        $this->middleware("adminMiddle");
    }

    public function index(Request $request)
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $DataTabel = Withdraw::with("user")
            ->whereNot("status", "Pending")
            ->paginate(10);

        foreach ($DataTabel as $withdraw) {
            $withdraw->user->rekening = $withdraw->user->rekening;
        }

        $data = array_merge($user, $website, [
            "page" => "Data Withdraw",
            "DataTabel" => $DataTabel,
        ]);

        return view("admin.data-withdraw", $data);
    }

    public function permintaan(Request $request)
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $DataTabel = Withdraw::with("user")
            ->where("status", "Pending")
            ->paginate(10);

        $data = array_merge($user, $website, [
            "page" => "Permintaan Withdraw",
            "DataTabel" => $DataTabel,
        ]);

        return view("admin.data-withdraw", $data);
    }

    public function Ajax(Request $request)
    {
        $url = $request->input("url");
        if ($url == "data-withdraw") {
            $DataTabel = Withdraw::with("user")
                ->whereNot("status", "Pending")
                ->paginate(10);
        } elseif ($url == "permintaan-withdraw") {
            $DataTabel = Withdraw::with("user")
                ->where("status", "Pending")
                ->paginate(10);
        }

        $partialView = view(
            "admin.partial.data-withdraw",
            compact("DataTabel")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function modalAjax(Request $request)
    {
        $id = $request->input("id");
        $us = User::where("id", $id)->first();

        $d = $us ? json_decode($us->rekening, false) : null;
        $partialView =
            '<tr>
                            <td>
                                Nama Bank
                            </td>
                            <td>
                                ' .
            $d->bank .
            '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Nama Rekening
                            </td>
                            <td>
                                ' .
            $d->nama .
            '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Nomor Rekening
                            </td>
                            <td>
                                ' .
            $d->rek .
            '
                            </td>
                        </tr>';

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function update_status(Request $request)
    {
        $id = $request->input("id");
        $tipe = $request->input("tipe");

        $data = Withdraw::findOrFail($id);
        $user = User::where("id", $data->user_id)->first();
        $reff = Referral::where("user_id", $data->user_id)->first();

        if ($tipe == "konfirmasi") {
            $data->update([
                "status" => "Sukses",
            ]);

            if ($reff) {
                $user_reff = User::where(
                    "kode_referral",
                    $reff->referral
                )->first();
                $saldo = str_replace(".", "", $data->nominal);
                $persentase = 5 / 100;
                $komisi = $saldo * $persentase;

                if ($reff->komisi === null) {
                    $user_reff->update([
                        "saldo" => $user_reff->saldo + $komisi,
                    ]);
                    $reff->update([
                        "komisi" => $komisi,
                    ]);

                    $logs = new Logs();
                    $logs->fill([
                        "user_id" => $user_reff->id,
                        "log_info" =>
                            "Kamu mendapatkan <b>" .
                            number_format($komisi, 0, ",", ".") .
                            "</b> dari Affiliasi dari <b>" .
                            $user->name .
                            "</b>",
                        "status" => "Sukses",
                    ]);
                    $logs->save();
                }
            }
        } elseif ($tipe == "cancel") {
            $data->update([
                "status" => "Cancel",
            ]);

            $saldo = str_replace(".", "", $data->nominal);

            $user->update([
                "saldo" => $user->saldo + $saldo,
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $data = Withdraw::findOrFail($id);
        $data->delete();

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }
}
