<?php

namespace App\Http\Controllers\User;

use Helper;
use Carbon\Carbon;
use App\Models\Logs;
use App\Models\Post;
use App\Models\User;
use App\Models\Tugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $user_id = Auth::id();
        // Get user data using the Helper method
        $user = Helper::getUserAuth();
        // Get additional data, such as website information, using the Helper method
        $website = Helper::getWebsite();

        $users = User::find($user_id);

        if ($users->role === "Worker") {
            $query = Tugas::query();
            $query->where("user_id", $user_id);
            $tugasItems = $query->with("post.category")->get();

            $query1 = Tugas::query();
            $query1->where("user_id", $user_id);
            $query1->where("status", 1);
            $status1Count = $query1->with("post.category")->get();

            $query2 = Tugas::query();
            $query2->where("user_id", $user_id);
            $query2->where("status", 2);
            $status2Count = $query2->with("post.category")->get();

            $query3 = Tugas::query();
            $query3->where("user_id", $user_id);
            $query3->where("status", 3);
            $status3Count = $query3->with("post.category")->get();

            $logs = Logs::where("user_id", $user_id)
                ->orderByDesc("id")
                ->limit(5)
                ->get();

            $data = array_merge($user, $website, [
                "jumlahTugas" => $tugasItems->count(),
                "Logs" => $logs,
                "Count1" => $status1Count,
                "Count2" => $status2Count,
                "Count3" => $status3Count,
            ]);
            //render view with home
            return view("user.dashboard", $data);
        } elseif ($users->role === "Employer") {
            return $this->employerFunction($user_id, $user, $website);
        }
    }

    public function employerFunction($user_id, $user, $website)
    {
        $user_id = Auth::id();
        $tugasItems = Post::where("user_id", $user_id)->get();

        $tugasIds = $tugasItems->pluck("id")->toArray();

        $query1 = Tugas::whereIn("post_id", $tugasIds)->where("status", 1);
        $status1Count = $query1->with("post.category")->get();

        $query2 = Tugas::whereIn("post_id", $tugasIds)->where("status", 2);
        $status2Count = $query2->with("post.category")->get();

        $query3 = Tugas::whereIn("post_id", $tugasIds)->where("status", 3);
        $status3Count = $query3->with("post.category")->get();

        $posts = Post::select(
            "posts.id",
            "posts.title as post_title",
            "posts.jumlah as jumlah",
            DB::raw(
                "COUNT(CASE WHEN tugas.status = 1 THEN 1 ELSE NULL END) as total"
            )
        )
            ->join("tugas", "posts.id", "=", "tugas.post_id")
            ->where("posts.user_id", $user_id)
            ->where("posts.status", "Berjalan")
            ->whereIn("posts.id", $tugasIds)
            ->groupBy("posts.id", "posts.title", "posts.jumlah")
            ->limit(5)
            ->get();

        $data = array_merge($user, $website, [
            "jumlahTugas" => $tugasItems->count(),
            "posts" => $posts,
            "tugasJalan" => $tugasItems
                ->filter(function ($item) {
                    return $item->status === "Berjalan";
                })
                ->count(),
            "tugasSelesai" => $tugasItems
                ->filter(function ($item) {
                    return $item->status === "Selesai";
                })
                ->count(),
            "Count1" => $status1Count,
            "Count2" => $status2Count,
            "Count3" => $status3Count,
        ]);

        //render view with home
        return view("user.dashboard", $data);
    }

    public function ganti_role(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);

        if ($user->role === "Worker") {
            $mode = "Employer";
            $user->update([
                "role" => "Employer",
            ]);
        } elseif ($user->role === "Employer") {
            $mode = "Worker";
            $user->update([
                "role" => "Worker",
            ]);
        }

        return redirect("dashboard")->with(
            "success",
            "Berhasil beralih ke mode <b>" . $mode . "</b>"
        );
    }

    public function calculateProfit()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Menghitung total profit pertahun
        $profitYearly = Tugas::selectRaw(
            "YEAR(created_at) AS year, SUM(komisi) AS total_profit"
        )
            ->groupBy("year")
            ->get();

        // Menghitung total profit per bulan dalam tahun ini
        $profitMonthly = Tugas::selectRaw(
            "MONTH(created_at) AS month, SUM(komisi) AS total_profit"
        )
            ->whereYear("created_at", $currentYear)
            ->groupBy("month")
            ->get();

        return [
            "profitYearly" => $profitYearly,
            "profitMonthly" => $profitMonthly,
        ];

        $profits = $this->calculateProfit();
        $profitYearly = $profits["profitYearly"];
        $profitMonthly = $profits["profitMonthly"];
    }
}
