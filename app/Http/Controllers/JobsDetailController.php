<?php

namespace App\Http\Controllers;

use Helper;
//return type View
use Carbon\Carbon;
//return type redirectResponse
use App\Models\Post;
//import Facade "Storage"
use App\Models\DataRepot;
use Illuminate\View\View;
use App\Models\Categories;
use App\Models\ReviewRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class JobsDetailController extends Controller
{
    public function index($slug): View
    {
        $post = Post::where("slug", $slug)->first();
        $id_user = Auth::id();

        if (!$post) {
            // Jika post tidak ditemukan, arahkan ke halaman 404
            abort(404);
        }

        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $posts = Post::join(
            "categories",
            "posts.category_id",
            "=",
            "categories.id"
        )
            ->join("users", "posts.user_id", "=", "users.id")
            ->leftJoin(
                DB::raw(
                    "(SELECT post_id, COUNT(*) as total_ratings, AVG(star_rating) as average_rating FROM review_ratings GROUP BY post_id) as rr"
                ),
                "posts.id",
                "=",
                "rr.post_id"
            )
            ->select(
                "posts.*",
                "categories.name as category_name",
                "categories.slug as category_slug",
                "posts.slug as post_slug",
                "users.avatar as profile_photo",
                "users.id as user_id",
                "users.name as user_name",
                "users.created_at as user_created_at",
                DB::raw("COALESCE(rr.total_ratings, 0) as total_ratings"),
                DB::raw("COALESCE(rr.average_rating, 0) as average_rating")
            )
            ->where("posts.slug", $slug)
            ->first();

        $tugasCounts = DB::table("tugas")
            ->select("status", DB::raw("COUNT(*) as total"))
            ->whereIn("status", [1, 2, 3])
            ->where("post_id", $posts->id)
            ->groupBy("status")
            ->get()
            ->keyBy("status");

        $UserRating = DB::table("review_ratings")
            ->join("users", "review_ratings.user_id", "=", "users.id")
            ->select(
                "review_ratings.*",
                "users.name as nama_user",
                "users.avatar as photo_user"
            )
            ->where("post_id", $posts->id)
            ->get();

        $UserRat = $UserRating->where("user_id", $id_user)->first();

        $TugasRate = DB::table("tugas")
            ->where("post_id", $posts->id)
            ->where("user_id", $id_user)
            ->first();

        $posts->each(function ($post) {
            if ($post->average_rating === null) {
                $post->average_rating = 0;
            }
        });

        $fileForm = $posts ? json_decode($posts->nama_file_form, false) : null;

        $data = array_merge($user, $website, [
            "post" => $posts,
            "tugasCounts" => $tugasCounts,
            "UserRating" => $UserRating,
            "userRat" => $UserRat,
            "TugasRate" => $TugasRate,
            "fileForm" => $fileForm,
        ]);

        //render view with home
        return view("home.detail-post", $data);
    }

    public function repot_job(Request $request)
    {
        $user_id = Auth::id();

        DataRepot::create([
            "user_id" => $user_id,
            "post_id" => $request->input("post_id"),
            "alasan" => $request->input("alasan"),
        ]);

        return response()->json(["success" => true]);
    }
}
