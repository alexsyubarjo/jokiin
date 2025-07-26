<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Models\User;
use App\Models\Tugas;
use App\Models\Deposit;
use App\Models\Website;
use App\Models\Withdraw;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class Dashboard extends Controller
{
    public function __construct()
    {
        $this->middleware("adminMiddle");
    }

    public function index(): View
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $tugasItems = Tugas::with("post.category")->get();
        $status1Count = Tugas::with("post.category")
            ->where("status", 1)
            ->get();
        $status2Count = Tugas::with("post.category")
            ->where("status", 2)
            ->get();
        $status3Count = Tugas::with("post.category")
            ->where("status", 3)
            ->get();

        $now = Carbon::now();
        $tahunSekarang = $now->year;

        $jumlahWD = Withdraw::sum("nominal");

        $totalNomWith = Withdraw::selectRaw(
            'SUM(REPLACE(nominal, ".", "")) as total, MONTH(created_at) as month'
        )
            ->whereYear("created_at", $tahunSekarang)
            ->whereIn(DB::raw("MONTH(created_at)"), range(1, 12))
            ->where("status", "Sukses")
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->pluck("total", "month")
            ->toArray();

        $totalNomDepo = Deposit::selectRaw(
            'SUM(REPLACE(nominal, ".", "")) as total, MONTH(created_at) as month'
        )
            ->whereYear("created_at", $tahunSekarang)
            ->whereIn(DB::raw("MONTH(created_at)"), range(1, 12))
            ->where("status", "Sukses")
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->pluck("total", "month")
            ->toArray();

        $bulan = [];
        $totalWD = [];
        $totalWith = [];
        $totalDepo = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulan[] = Carbon::create()
                ->month($i)
                ->format("M");
            $totalDepo[] = isset($totalNomDepo[$i]) ? $totalNomDepo[$i] : 0;
        }

        for ($i = 1; $i <= 12; $i++) {
            if (isset($totalNomWith[$i])) {
                $inal = $totalNomWith[$i] * ($wd = $website["web"]->wd / 100);
                $nominal = $totalNomWith[$i] - $inal;
                $totalWith[] = $nominal;
            } else {
                $totalWith[] = 0;
            }
        }

        for ($i = 1; $i <= 12; $i++) {
            if (isset($totalNomWith[$i])) {
                $nominal =
                    $totalNomWith[$i] * ($wd = $website["web"]->wd / 100);
                $totalWD[] = $nominal;
            } else {
                $totalWD[] = 0;
            }
        }

        $currentMonth = date("n"); // Nomor bulan saat ini
        $previousMonth = $currentMonth - 1; // Nomor bulan sebelumnya

        $currentMonthTotal = isset($totalNomWith[$currentMonth])
            ? $totalNomWith[$currentMonth]
            : 0;
        $previousMonthTotal = isset($totalNomWith[$previousMonth])
            ? $totalNomWith[$previousMonth]
            : 0;

        $percentageChange = 0;
        if ($previousMonthTotal != 0) {
            $percentageChange =
                (($currentMonthTotal - $previousMonthTotal) /
                    $previousMonthTotal) *
                100;
        }

        $TopWork = User::orderBy("saldo", "desc")
            ->take(5)
            ->get();

        $data = array_merge($user, $website, [
            "page" => "Dashboard",
            "jumlahTugas" => $tugasItems->count(),
            "Count1" => $status1Count,
            "Count2" => $status2Count,
            "Count3" => $status3Count,
            "bulan" => $bulan,
            "jumlahWD" => $jumlahWD,
            "totalWD" => $totalWD,
            "totalWith" => $totalWith,
            "totalDepo" => $totalDepo,
            "percentageChange" => $percentageChange,
            "TopWork" => $TopWork,
        ]);

        return view("admin.dashboard", $data);
    }
}
