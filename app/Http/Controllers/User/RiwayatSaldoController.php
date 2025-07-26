<?php

namespace App\Http\Controllers\User;

use Helper;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RiwayatSaldoController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $user_id = Auth::id();
        $user = Helper::getUserAuth();

        // Get additional data, such as website information, using the Helper method
        $website = Helper::getWebsite();

        // Merge user and website data into a single array
        $data = array_merge($user, $website);

        // Retrieve RiwayatSaldo data from the database
        $riwayatSaldo = Withdraw::where("user_id", $user_id)
            ->latest("created_at")
            ->paginate(5);

        //sweetalert
        $title = "Hapus Data!";
        $text = "Apakah Anda yakin ingin menghapus?";
        confirmDelete($title, $text);

        // Pass the RiwayatSaldo data to the view
        return view("user.riwayat-penarikan", compact("riwayatSaldo"))->with(
            $data
        );
    }

    public function AjaxLogsaldo(Request $request)
    {
        $user_id = Auth::id();

        $riwayatSaldo = Withdraw::where("user_id", $user_id)
            ->latest("created_at")
            ->paginate(5);

        $partialView = view(
            "user.partial.log-saldo",
            compact("riwayatSaldo")
        )->render();

        $startingNumber =
            ($riwayatSaldo->currentPage() - 1) * $riwayatSaldo->perPage() + 1;

        return response()->json([
            "partialView" => $partialView,
            "startingNumber" => $startingNumber,
        ]);
    }
}
