<?php

namespace App\Http\Controllers\User;

use App\Models\Post;
use App\Models\Tugas;
use Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DataTugasController extends Controller
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

        $posts = Post::where("user_id", $user_id)->get();
        $postId = $posts->pluck("id")->toArray();

        $tugasItems = Tugas::whereIn("post_id", $postId)
            ->whereNot("status", 2)
            ->join("users", "tugas.user_id", "=", "users.id")
            ->select("tugas.*", "users.name AS nama_user")
            ->paginate(5);

        $data = [
            "tugasItems" => $tugasItems,
        ];

        $data = array_merge($user, $website, $data);

        return view("user.employer.semua-tugas", $data);
    }

    public function paginationAjax(Request $request)
    {
        $user_id = Auth::id();

        $posts = Post::where("user_id", $user_id)->get();
        $postId = $posts->pluck("id")->toArray();

        $tugasItems = Tugas::whereIn("post_id", $postId)
            ->whereNot("status", 2)
            ->join("users", "tugas.user_id", "=", "users.id")
            ->select("tugas.*", "users.name AS nama_user")
            ->paginate(5);

        $partialView = view(
            "user.partial.semua-tugas-load",
            compact("tugasItems")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }
}
