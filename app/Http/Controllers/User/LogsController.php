<?php

namespace App\Http\Controllers\User;

use Helper;
use App\Models\Logs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $user_id = Auth::id();

        $logs = Logs::where("user_id", $user_id)
            ->orderByDesc("id")
            ->paginate(5);

        $data = array_merge($user, $website, [
            "Logs" => $logs,
        ]);
        return view("user.logs", $data);
    }

    public function AjaxLogs(Request $request)
    {
        $user_id = Auth::id();

        $Logs = Logs::where("user_id", $user_id)
            ->orderByDesc("id")
            ->paginate(5);

        $partialView = view(
            "user.partial.logs-load",
            compact("Logs")
        )->render();

        return response()->json([
            "partialView" => $partialView,
        ]);
    }
}
