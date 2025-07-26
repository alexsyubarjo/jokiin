<?php

namespace App\Http\Controllers\User;

use Helper;
use App\Models\Post;
use App\Models\Tugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(Request $request)
    {
        $user_id = Auth::id();
        $status = $request->query("status", "semua");
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $query = Tugas::query();
        if ($status == "selesai") {
            $query->where("status", 1);
        } elseif ($status == "pending") {
            $query->where("status", 2);
        } elseif ($status == "ditolak") {
            $query->where("status", 3);
        }
        $query->where("user_id", $user_id);
        $tugasItems = $query
            ->with("post.category")
            ->orderByDesc("id")
            ->paginate(5);

        $totalTugas = Tugas::where("user_id", $user_id)->count();
        $status1Count = Tugas::where("user_id", $user_id)
            ->where("status", 1)
            ->count();
        $status2Count = Tugas::where("user_id", $user_id)
            ->where("status", 2)
            ->count();
        $status3Count = Tugas::where("user_id", $user_id)
            ->where("status", 3)
            ->count();

        $data = [
            "tugasItems" => $tugasItems,
            "jumlahTugas" => $totalTugas,
            "Count1" => $status1Count,
            "Count2" => $status2Count,
            "Count3" => $status3Count,
            "status" => $status,
        ];

        $data = array_merge($user, $website, $data);

        return view("user.tugas", $data);
    }

    public function paginationAjax(Request $request)
    {
        $user_id = Auth::id();
        $status = $request->query("status", "semua");

        $query = Tugas::query();
        if ($status == "selesai") {
            $query->where("status", 1);
        } elseif ($status == "pending") {
            $query->where("status", 2);
        } elseif ($status == "ditolak") {
            $query->where("status", 3);
        }
        $query->where("user_id", $user_id);
        $tugasItems = $query
            ->with("post.category")
            ->orderByDesc("id")
            ->paginate(5);

        $partialView = view(
            "user.partial.tugas-load",
            compact("tugasItems")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function get_data_bukti(Request $request)
    {
        $id = $request->input("id");

        $query = Tugas::query();
        $post = $query->where("id", $id)->first();
        $Tugas = $post ? json_decode($post->bukti, true) : null;

        $partialView = view(
            "user.partial.file-bukti",
            compact("Tugas")
        )->render();

        // Return the partial view as JSON response
        return response()->json(["partialView" => $partialView]);
    }

    public function input(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->input("post_id");
        $comments = $request->input("comment");
        $bukti = [];

        // Mengambil data bukti dari form
        $fileForm = $request->except(["_token", "post_id", "comment"]);
        foreach ($fileForm as $key => $value) {
            // Jika ada bukti yang diunggah, tambahkan ke array bukti
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $extension = $file->getClientOriginalExtension();
                $filename = Str::random(40) . "." . $extension;
                $path = $file->storeAs("public/tugas", $filename); // Simpan file ke direktori public/tugas
                $bukti[$key] = $filename;
            }
        }

        // Mengubah array bukti menjadi format JSON
        $buktiJson = json_encode($bukti, JSON_UNESCAPED_SLASHES);

        // Menyimpan data ke tabel "tugas"
        DB::table("tugas")->insert([
            "user_id" => $user_id,
            "post_id" => $post_id,
            "comments" => $comments,
            "bukti" => $buktiJson,
            "status" => "2",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        return redirect()
            ->route("dashboard.task")
            ->with(
                "success",
                "Bukti Anda telah berhasil dikirim. <br /> Tunggu konfirmasi dari Employer"
            );
    }
}
