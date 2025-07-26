<?php

namespace App\Http\Controllers;

use Helper;
//return type View
use Carbon\Carbon;
//return type redirectResponse
use App\Models\Post;
//import Facade "Storage"
use App\Models\User;
use Illuminate\View\View;
use App\Models\Categories;
use App\Models\ReviewRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class WebsiteController extends Controller
{
    public function index(): View
    {
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
            ->latest("posts.created_at")
            ->paginate(6);

        $posts->each(function ($post) {
            if ($post->average_rating === null) {
                $post->average_rating = 0;
            }
        });

        $data = array_merge($user, $website, [
            "Categories" => $Categories,
            "postCounts" => $postCounts,
            "posts" => $posts,
        ]);

        return view("home.index", $data);
    }

    public function top_worker(): View
    {
        //get home
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $data = array_merge($user, $website);

        //render view with home
        return view("home.top-worker", $data);
    }

    public function about(): View
    {
        //get home
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $data = array_merge($user, $website);

        //render view with home
        return view("home.about", $data);
    }

    public function terms(): View
    {
        //get home
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $data = array_merge($user, $website);

        //render view with home
        return view("home.terms", $data);
    }

    public function privacy(): View
    {
        //get home
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $data = array_merge($user, $website);

        //render view with home
        return view("home.privacy", $data);
    }

    public function calculateAverageRating($postId)
    {
        $ratings = ReviewRating::where("post_id", $postId)
            ->where("status", "active")
            ->get();

        $totalRatings = $ratings->count();
        $averageRating = $ratings->avg("star_rating");

        return [
            "total_ratings" => $totalRatings,
            "average_rating" => $averageRating ?? 0,
        ];
    }

    public function referral($referral)
    {
        // Cek apakah referral code ada pada data pengguna
        $user = User::where("kode_referral", $referral)->first();
        if ($user) {
            // Simpan referral code dalam sesi
            Session::put("referral_code", $referral);
            return redirect("register");
        } else {
            abort("404");
        }
    }
}
