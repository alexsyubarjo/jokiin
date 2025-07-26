<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Tugas;
use App\Models\Deposit;
use App\Models\Message;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Services\NotificationService;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        View::composer("*", function ($view) {
            $user_id = Auth::id();
            $posts = Post::where("user_id", $user_id)->get();
            $postId = $posts->pluck("id")->toArray();
            $status2Count = Tugas::whereIn("post_id", $postId)
                ->where("status", 2)
                ->count();
            $view->with("notifTugas", $status2Count);

            $notif_pesan = Message::where("seen", 1)
                ->whereNot("sender_id", $user_id)
                ->where(function ($query) use ($user_id) {
                    $query
                        ->where("sender_id", "!=", $user_id)
                        ->orWhere("receiver_id", "!=", $user_id);
                })
                ->where(function ($query) use ($user_id) {
                    $query
                        ->where("sender_id", $user_id)
                        ->orWhere("receiver_id", $user_id);
                })
                ->count();
            $view->with("notif_pesan", $notif_pesan);

            $depo = Deposit::where("status", "Pending")->count();
            $view->with("notifDepo", $depo);

            $withdraw = Withdraw::where("status", "Pending")->count();
            $view->with("notifWD", $withdraw);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
