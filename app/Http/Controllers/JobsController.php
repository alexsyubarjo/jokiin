<?php

namespace App\Http\Controllers;

use Helper;
use App\Models\Post;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        $catte = $request->input("category");
        $search = $request->input("search");
        //get home
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        // Mendapatkan semua Categories
        $Categories = Categories::all();

        // Mendeklarasikan array untuk menyimpan jumlah post per Categories
        $postCounts = [];

        // Menghitung jumlah post per Categories
        foreach ($Categories as $kat) {
            $postCount = Post::where("category_id", $kat->id)->count();
            $postCounts[$kat->id] = $postCount;
        }

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
                "users.name as user_name",
                DB::raw("COALESCE(rr.total_ratings, 0) as total_ratings"),
                DB::raw("COALESCE(rr.average_rating, 0) as average_rating")
            )
            ->where("status", "Berjalan")
            ->orderByDesc("rr.total_ratings")
            ->latest("posts.created_at");

        $posts->each(function ($post) {
            if ($post->average_rating === null) {
                $post->average_rating = 0;
            }
        });

        if ($catte) {
            $posts->where("categories.slug", $catte);
        }

        // Filter berdasarkan pencarian
        if ($search) {
            $posts->where(function ($query) use ($search) {
                $query
                    ->where("categories.name", "like", "%" . $search . "%")
                    ->orwhere("posts.title", "like", "%" . $search . "%");
            });
        }

        $posts = $posts->paginate(6);

        $data = array_merge($user, $website, [
            "Categories" => $Categories,
            "postCounts" => $postCounts,
            "posts" => $posts,
        ]);

        //render view with home
        return view("home.jobs", $data);
    }

    function paginationAjax(Request $request)
    {
        $catte = $request->input("category");
        $range = $request->input("range");
        $search = $request->input("search");

        if ($request->ajax()) {
            // Query builder untuk mencari post
            $posts = Post::join(
                "categories",
                "posts.category_id",
                "=",
                "categories.id"
            )
                ->join("users", "posts.user_id", "=", "users.id")
                ->select(
                    "posts.*",
                    "categories.name as category_name",
                    "categories.slug as category_slug",
                    "posts.slug as post_slug",
                    "users.name as user_name"
                )
                ->latest("created_at");

            // Filter berdasarkan kategori
            if ($catte) {
                $posts->where("categories.slug", $catte);
            }

            // Filter berdasarkan range
            if ($range) {
                $posts->where("posts.komisi", ">=", $range);
            }

            // Filter berdasarkan pencarian
            if ($search) {
                $posts->where(function ($query) use ($search) {
                    $query->where("posts.title", "like", "%" . $search . "%");
                });
            }

            $posts = $posts->paginate(6);

            // Render partial view with
            $partialView = view(
                "home.partial.jobs-load",
                compact("posts")
            )->render();

            // Return the partial view as JSON response
            return response()->json(["partialView" => $partialView]);
        }
    }

    public function calculateAverageRating($postId)
    {
        $ratings = ReviewRating::where("post_id", $postId)
            ->where("status", "active")
            ->pluck("star_rating");

        $totalRatings = $ratings->count();
        $averageRating = $ratings->avg();

        return $averageRating;
    }
}
