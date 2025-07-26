<?php

namespace App\Http\Controllers\User;

use App\Models\ReviewRating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewRatingController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(Request $request, $slug)
    {
        $existingReview = ReviewRating::where("post_id", $request->post_id)
            ->where("user_id", Auth::id())
            ->first();

        if ($existingReview) {
            // Update review
            $existingReview->comments = $request->comment;
            $existingReview->star_rating = $request->rating;
            $existingReview->save();
        } else {
            // Create new review
            $review = new ReviewRating();
            $review->post_id = $request->post_id;
            $review->user_id = Auth::id();
            $review->comments = $request->comment;
            $review->star_rating = $request->rating;
            $review->save();
        }

        return redirect("detail-jobs/" . $slug)->with(
            "success",
            "Ulasan Anda telah berhasil dikirim."
        );
    }
}
