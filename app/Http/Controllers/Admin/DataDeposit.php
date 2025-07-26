<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Models\User;
use App\Models\Deposit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class DataDeposit extends Controller
{
    public function __construct()
    {
        $this->middleware("adminMiddle");
    }

    public function index(Request $request)
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $DataTabel = Deposit::with("user")
            ->whereNot("status", "Pending")
            ->paginate(10);

        $data = array_merge($user, $website, [
            "page" => "Data Deposit",
            "DataTabel" => $DataTabel,
        ]);

        return view("admin.data-deposit", $data);
    }

    public function permintaan(Request $request)
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $DataTabel = Deposit::with("user")
            ->where("status", "Pending")
            ->paginate(10);

        $data = array_merge($user, $website, [
            "page" => "Permintaan Deposit",
            "DataTabel" => $DataTabel,
        ]);

        return view("admin.data-deposit", $data);
    }

    public function Ajax(Request $request)
    {
        $url = $request->input("url");
        if ($url == "data-deposit") {
            $DataTabel = Deposit::with("user")
                ->whereNot("status", "Pending")
                ->paginate(10);
        } elseif ($url == "permintaan-deposit") {
            $DataTabel = Deposit::with("user")
                ->where("status", "Pending")
                ->paginate(10);
        }

        $partialView = view(
            "admin.partial.data-deposit",
            compact("DataTabel")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function update_status(Request $request)
    {
        $id = $request->input("id");
        $tipe = $request->input("tipe");

        $data = Deposit::findOrFail($id);

        if ($tipe == "konfirmasi") {
            $data->update([
                "status" => "Sukses",
            ]);

            $saldo = str_replace(".", "", $data->nominal);

            $user = User::where("id", $data->user_id)->first();

            $user->update([
                "saldo_employer" => $user->saldo_employer + $saldo,
            ]);
        } elseif ($tipe == "cancel") {
            $data->update([
                "status" => "Cancel",
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
        $data = Deposit::findOrFail($id);
        $data->delete();

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }
}
