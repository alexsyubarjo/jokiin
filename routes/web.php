<?php

use Illuminate\Http\Request;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Middleware\UserActivity;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\JsonController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebsiteController;

use App\Http\Controllers\CallbackController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\JobsDetailController;
use App\Http\Controllers\User as UserController;
use App\Http\Controllers\Admin as AdminController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;

//Page Home
Route::get("/", [WebsiteController::class, "index"]);
Route::get("/register/{referral}", [WebsiteController::class, "referral"]);

Route::prefix("jobs")
    ->name("jobs.")
    ->group(function () {
        Route::get("/", [JobsController::class, "index"])->name("index");
        Route::get("ajax", [JobsController::class, "paginationAjax"]);
    });

Route::get("top_worker", [WebsiteController::class, "top_worker"]);
Route::get("about_us", [WebsiteController::class, "about"]);
Route::get("terms_and_conditions", [WebsiteController::class, "terms"]);
Route::get("privacy_policy", [WebsiteController::class, "privacy"]);
Route::get("detail-jobs/{slug}", [JobsDetailController::class, "index"]);
Route::get("callback/duitku", [
    CallbackController::class,
    "handleCallbackDuitku",
]);
Route::post("repot-job", [
    JobsDetailController::class,
    "repot_job",
])->middleware("auth");

Auth::routes();

Route::group(["middleware" => "auth"], function () {
    Route::post("bukti_tugas", [
        UserController\TugasController::class,
        "input",
    ]);
    Route::post("review_rating/{slug}", [
        UserController\ReviewRatingController::class,
        "index",
    ]);

    Route::group(["prefix" => "dashboard"], function () {
        Route::get("/", [
            UserController\DashboardController::class,
            "index",
        ])->name("dashboard");

        Route::resource("pesan", UserController\MessageController::class);
        Route::get("chat_ajax", [
            UserController\MessageController::class,
            "chatAjax",
        ]);
        Route::get("chat_seen", [
            UserController\MessageController::class,
            "chatSeen",
        ]);
        Route::get("hapus_chat", [
            UserController\MessageController::class,
            "destroy",
        ]);

        Route::get("edit-profile", [
            UserController\EditProfileController::class,
            "index",
        ])->name("profile.edit");

        Route::put("/edit-profile-post", [
            UserController\EditProfileController::class,
            "update",
        ])->name("profile.update");

        Route::post("password-reset", [
            UserController\EditProfileController::class,
            "updatePassword",
        ])->name("password.update");

        Route::group(["prefix" => "referral"], function () {
            Route::get("/", [
                UserController\ReferralController::class,
                "index",
            ])->name("profile.referral");
            Route::post("update", [
                UserController\ReferralController::class,
                "update",
            ])->name("update.referral");
            Route::get("Ajax", [
                UserController\ReferralController::class,
                "AjaxReff",
            ]);
        });

        Route::get("get_data_bukti", [
            UserController\TugasController::class,
            "get_data_bukti",
        ])->name("get_data_bukti");

        Route::get("ganti-role", [
            UserController\DashboardController::class,
            "ganti_role",
        ]);

        Route::group(["middleware" => "role:Worker"], function () {
            Route::get("task", [
                UserController\TugasController::class,
                "index",
            ])->name("dashboard.task");
            Route::get("task_ajax", [
                UserController\TugasController::class,
                "paginationAjax",
            ]);

            Route::get("tarik-saldo", [
                UserController\WithdrawController::class,
                "index",
            ]);

            Route::post("withdraw-dana", [
                UserController\WithdrawController::class,
                "store",
            ]);

            Route::get("rekening", [
                UserController\RekeningController::class,
                "index",
            ]);
            Route::post("edit_rekening", [
                UserController\RekeningController::class,
                "store",
            ]);

            Route::get("logs", [UserController\LogsController::class, "index"]);
            Route::get("pagination/Logs", [
                UserController\LogsController::class,
                "AjaxLogs",
            ]);

            Route::resource(
                "riwayat-penarikan",
                UserController\RiwayatSaldoController::class
            );

            Route::get("pagination/LogSaldo", [
                UserController\RiwayatSaldoController::class,
                "AjaxLogsaldo",
            ]);
        });

        Route::group(["middleware" => "role:Employer"], function () {
            Route::get("tugas-pending", [
                UserController\TugasPendingController::class,
                "index",
            ]);
            Route::get("task_ajax_employer", [
                UserController\TugasPendingController::class,
                "paginationAjax",
            ]);
            Route::get("tugas_aksi", [
                UserController\TugasPendingController::class,
                "tugas_aksi",
            ]);
            Route::get("semua-tugas", [
                UserController\DataTugasController::class,
                "index",
            ]);
            Route::get("data_task_ajax", [
                UserController\DataTugasController::class,
                "paginationAjax",
            ]);
            Route::resource("posts", UserController\PostController::class);
            Route::get("data-tugas-ajax", [
                UserController\PostController::class,
                "paginationAjax",
            ]);

            Route::get("deposit-saldo", [
                UserController\DepositSaldoController::class,
                "index",
            ]);
            Route::post("deposit-manual", [
                UserController\DepositSaldoController::class,
                "deposit_manual",
            ]);
            Route::get("batal-deposit", [
                UserController\DepositSaldoController::class,
                "batal_deposit",
            ]);
            Route::get("riwayat-deposit", [
                UserController\DepositSaldoController::class,
                "riwayat_deposit",
            ]);
            Route::get("riwayat-deposit-ajax", [
                UserController\DepositSaldoController::class,
                "AjaxDeposit",
            ]);
            Route::get("invoice-deposit", [
                UserController\DepositSaldoController::class,
                "InvoiceDeposit",
            ]);
        });
    });

    Route::get("pay-duitku", [PaymentController::class, "PayDuitku"]);
    Route::get("respon-duitku", [PaymentController::class, "responDuitku"]);

    Route::post("/logout", [
        App\Http\Controllers\Auth\LoginController::class,
        "logout",
    ])->name("logout");
});

//Auth Sosmed
Route::group(["prefix" => "auth"], function () {
    Route::get("activate/{target:token}", [
        \App\Http\Controllers\Auth\ActivateAccountController::class,
        "activate",
    ])->withoutMiddleware(["auth", "cookie"]);
    Route::get("{provider}", [LoginController::class, "redirectToProvider"]);
    Route::get("{provider}/callback", [
        LoginController::class,
        "handleProviderCallback",
    ]);
});

Route::group(["prefix" => "ganti/password"], function () {
    Route::get("/", [ResetPasswordController::class, "get"])->name(
        "password.request"
    );
    Route::get("/change/{reset_token}", [
        ResetPasswordController::class,
        "change",
    ])->name("password.change");
    Route::post("/post", [ResetPasswordController::class, "post"])->name(
        "password.post"
    );
    Route::post("/post_pass", [
        ResetPasswordController::class,
        "post_pass",
    ])->name("password.update");
});
Route::get("password/email", [ResetPasswordController::class, "get"]);

//Page Admin
Route::group(["prefix" => "admin", "namespace" => "Admin"], function () {
    Route::get("login", [AdminLoginController::class, "login"])->name(
        "adminLogin"
    );
    Route::post("login", [AdminLoginController::class, "loginForm"])->name(
        "adminLoginPost"
    );

    Route::get("/logout", [AdminLoginController::class, "adminLogout"])->name(
        "adminLogout"
    );

    Route::group(["middleware" => "admin"], function () {
        Route::get("/", [AdminController\Dashboard::class, "index"])->name(
            "adminDashboard"
        );
        Route::group(["prefix" => "data-kategori"], function () {
            Route::get("/", [AdminController\DataCategory::class, "index"]);
            Route::get("ajax", [AdminController\DataCategory::class, "Ajax"]);
            Route::get("get-data-kategori", [
                AdminController\DataCategory::class,
                "get_data_kategori",
            ])->name("get_data_kategori");
            Route::post("store", [
                AdminController\DataCategory::class,
                "store",
            ]);
            Route::post("update", [
                AdminController\DataCategory::class,
                "update",
            ]);
            Route::post("destroy", [
                AdminController\DataCategory::class,
                "destroy",
            ]);
        });
        Route::group(["prefix" => "data-bank"], function () {
            Route::get("/", [
                AdminController\DataBankController::class,
                "index",
            ]);
            Route::get("ajax", [
                AdminController\DataBankController::class,
                "Ajax",
            ]);
            Route::get("get-data-bank", [
                AdminController\DataBankController::class,
                "get_data_bank",
            ])->name("get_data_bank");
            Route::post("store", [
                AdminController\DataBankController::class,
                "store",
            ]);
            Route::post("update", [
                AdminController\DataBankController::class,
                "update",
            ]);
            Route::post("destroy", [
                AdminController\DataBankController::class,
                "destroy",
            ]);
        });

        Route::group(["prefix" => "data-pengguna"], function () {
            Route::get("/", [AdminController\DataPengguna::class, "index"]);
            Route::get("user-verifikasi", [
                AdminController\DataPengguna::class,
                "user_verifikasi",
            ]);
            Route::get("get-data", [
                AdminController\DataPengguna::class,
                "get_data_user",
            ])->name("get_data_user");
            Route::get("ajax", [AdminController\DataPengguna::class, "Ajax"]);
            Route::post("update", [
                AdminController\DataPengguna::class,
                "update",
            ]);
            Route::post("verif", [
                AdminController\DataPengguna::class,
                "verifikasi",
            ]);
            Route::post("destroy", [
                AdminController\DataPengguna::class,
                "destroy",
            ]);
        });
        Route::group(["prefix" => "data-jobs"], function () {
            Route::get("/", [AdminController\DataJobs::class, "index"]);
            Route::get("ajax", [AdminController\DataJobs::class, "Ajax"]);
            Route::post("destroy", [
                AdminController\DataJobs::class,
                "destroy",
            ]);
        });

        Route::group(["prefix" => "data-repot"], function () {
            Route::get("/", [AdminController\DataJobs::class, "data_repot"]);
            Route::get("ajax", [
                AdminController\DataJobs::class,
                "data_repot_Ajax",
            ]);
            Route::get("modal-ajax", [
                AdminController\DataJobs::class,
                "data_repot_modal_Ajax",
            ]);
            Route::get("get-data-post", [
                AdminController\DataJobs::class,
                "get_data_post",
            ])->name("get_data_post");
            Route::post("update-status", [
                AdminController\DataJobs::class,
                "update_status",
            ]);
            Route::post("destroy", [
                AdminController\DataJobs::class,
                "repot_destroy",
            ]);
        });

        Route::group(["prefix" => "data-withdraw"], function () {
            Route::get("/", [AdminController\DataWithdraw::class, "index"]);
            Route::get("permintaan-withdraw", [
                AdminController\DataWithdraw::class,
                "permintaan",
            ]);
            Route::get("ajax", [AdminController\DataWithdraw::class, "Ajax"]);
            Route::get("modal-ajax", [
                AdminController\DataWithdraw::class,
                "modalAjax",
            ]);
            Route::post("update-status", [
                AdminController\DataWithdraw::class,
                "update_status",
            ]);
            Route::post("destroy", [
                AdminController\DataWithdraw::class,
                "destroy",
            ]);
        });

        Route::group(["prefix" => "data-deposit"], function () {
            Route::get("/", [AdminController\DataDeposit::class, "index"]);
            Route::get("permintaan-deposit", [
                AdminController\DataDeposit::class,
                "permintaan",
            ]);
            Route::get("ajax", [AdminController\DataDeposit::class, "Ajax"]);
            Route::post("update-status", [
                AdminController\DataDeposit::class,
                "update_status",
            ]);
            Route::post("destroy", [
                AdminController\DataDeposit::class,
                "destroy",
            ]);
        });

        Route::group(["prefix" => "data-tugas"], function () {
            Route::get("/", [AdminController\DataTugas::class, "index"]);
            Route::get("ajax", [AdminController\DataTugas::class, "Ajax"]);
            Route::get("modal-ajax", [
                AdminController\DataTugas::class,
                "modalAjax",
            ]);
            Route::get("get-data-post", [
                AdminController\DataTugas::class,
                "get_data_tugas",
            ])->name("get_data_tugas");
            Route::post("update-status", [
                AdminController\DataTugas::class,
                "update_status",
            ]);
            Route::post("destroy", [
                AdminController\DataTugas::class,
                "destroy",
            ]);
        });

        Route::group(["prefix" => "setting-utama"], function () {
            Route::get("/", [AdminController\SettingWebsite::class, "index"]);
            Route::post("update", [
                AdminController\SettingWebsite::class,
                "update_utama",
            ]);
            Route::post("update-about-us", [
                AdminController\SettingWebsite::class,
                "update_about_us",
            ]);
        });

        Route::group(["prefix" => "setting-logo"], function () {
            Route::get("/", [
                AdminController\SettingWebsite::class,
                "setting_logo",
            ]);
            Route::post("update", [
                AdminController\SettingWebsite::class,
                "update_logo",
            ]);
            Route::post("update-fav", [
                AdminController\SettingWebsite::class,
                "update_logo_fav",
            ]);
        });

        Route::group(["prefix" => "media-sosial"], function () {
            Route::get("/", [
                AdminController\SettingWebsite::class,
                "media_sosial",
            ]);
            Route::post("update", [
                AdminController\SettingWebsite::class,
                "update_sosmed",
            ]);
        });

        Route::group(["prefix" => "smtp-email"], function () {
            Route::get("/", [
                AdminController\SettingWebsite::class,
                "smtp_email",
            ]);
            Route::post("update", [
                AdminController\SettingWebsite::class,
                "update_smtp_email",
            ]);
        });

        Route::group(["prefix" => "setting-payment"], function () {
            Route::get("/", [AdminController\SettingWebsite::class, "payment"]);
            Route::post("update", [
                AdminController\SettingWebsite::class,
                "update_payment",
            ]);
        });

        Route::group(["prefix" => "lain-lain"], function () {
            Route::get("/", [
                AdminController\SettingWebsite::class,
                "lain_lain",
            ]);
            Route::post("update", [
                AdminController\SettingWebsite::class,
                "update_lain_lain",
            ]);
            Route::post("update-privacy", [
                AdminController\SettingWebsite::class,
                "update_lain_lain_privacy",
            ]);
        });

        Route::group(["prefix" => "setting-bank"], function () {
            Route::get("/", [AdminController\SettingBank::class, "index"]);
            Route::get("ajax", [AdminController\SettingBank::class, "Ajax"]);
            Route::get("get-setting-bank", [
                AdminController\SettingBank::class,
                "get_setting_bank",
            ])->name("get_setting_bank");
            Route::post("store", [AdminController\SettingBank::class, "store"]);
            Route::post("update", [
                AdminController\SettingBank::class,
                "update",
            ]);
            Route::post("destroy", [
                AdminController\SettingBank::class,
                "destroy",
            ]);
        });

        Route::group(["prefix" => "setting-akun"], function () {
            Route::get("/", [AdminController\SettingAkun::class, "index"]);
            Route::post("update", [
                AdminController\SettingAkun::class,
                "update",
            ]);
            Route::post("update-password", [
                AdminController\SettingAkun::class,
                "updatePassword",
            ]);
        });
    });
});
