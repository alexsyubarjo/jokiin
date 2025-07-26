<?php

namespace App\Http\Controllers\User;

use Helper;
use App\Models\Logs;
use App\Models\Post;
use App\Models\User;
use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TugasPendingController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(Request $request)
    {
        $user_id = Auth::id();
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        // Retrieve all posts associated with the user
        $posts = Post::where("user_id", $user_id)->get();
        $postIds = $posts->pluck("id")->toArray();

        // Initialize an empty collection for the tugasItems
        $tugasItems = collect();

        // If the user has posts, fetch the corresponding tugasItems
        if (!empty($postIds)) {
            $tugasItems = Tugas::whereIn("post_id", $postIds)
                ->where("status", 2)
                ->join("users", "tugas.user_id", "=", "users.id")
                ->select("tugas.*", "users.name AS nama_user")
                ->with("post.category")
                ->orderBy("id", "desc")
                ->paginate(5);
        }

        $data = [
            "tugasItems" => $tugasItems,
        ];
        $data = array_merge($user, $website, $data);

        return view("user.employer.tugas", $data);
    }

    public function paginationAjax(Request $request)
    {
        $user_id = Auth::id();

        $posts = Post::where("user_id", $user_id)->get();
        $postId = $posts->pluck("id")->toArray();

        $tugasItems = Tugas::whereIn("post_id", $postId)
            ->where("status", 2)
            ->join("users", "tugas.user_id", "=", "users.id")
            ->select("tugas.*", "users.name AS nama_user")
            ->with("post.category")
            ->orderBy("id", "desc")
            ->paginate(5);

        $partialView = view(
            "user.partial.tugas-pending-load",
            compact("tugasItems")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function tugas_aksi(Request $request)
    {
        $user_id = Auth::id();
        $id = $request->input("id");
        $aksi = $request->input("aksi");

        $tugas = Tugas::find($id);
        $post = Post::where("id", $tugas->post_id)->first();
        $user = User::where("id", $tugas->user_id)->first();
        $employer = User::where("id", $user_id)->first();
        $logs = new Logs();

        $cek_sum = Tugas::where("post_id", $tugas->post_id)
            ->where("status", 1)
            ->get();

        if ($cek_sum->count() == $post->jumlah) {
            return response()->json([
                "success" => false,
                "message" => "Tugas kamu sudah selesai",
            ]);
        }

        if ($aksi === "terima") {
            if ($employer->saldo_employer < $post->komisi) {
                return response()->json([
                    "success" => false,
                    "message" => "Saldo tidak mencukupi",
                ]);
            }
            $tugas->update([
                "status" => 1,
            ]);

            $logs->user_id = $user->id;
            $logs->log_info =
                "Kamu mendapatkan <b>" .
                $post->komisi .
                "</b> dari Tugas <b>" .
                $post->title .
                "</b>";
            $logs->status = "Sukses";
            $logs->save();

            $user->update([
                "saldo" => $user->saldo + $post->komisi,
            ]);
            $employer->update([
                "saldo_employer" => $employer->saldo_employer - $post->komisi,
            ]);
        } elseif ($aksi === "tolak") {
            $tugas->update([
                "status" => 3,
            ]);

            $logs->user_id = $user->id;
            $logs->log_info =
                "Tugas anda <b>" . $post->title . "</b> di tolak Employer.";
            $logs->status = "Error";
            $logs->save();
        } elseif ($aksi === "batalkan") {
            $tugas->update([
                "status" => 2,
            ]);

            $logs->user_id = $user->id;
            $logs->log_info =
                "Employer membatalkan penolakan dari Tugas <b>" .
                $post->title .
                "</b>";
            $logs->status = "Info";
            $logs->save();
        }

        $isPostFinished =
            Tugas::where("post_id", $tugas->post_id)
                ->where("status", 1)
                ->count() == $post->jumlah;

        if ($isPostFinished) {
            $post->update([
                "status" => "Selesai",
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }
}
