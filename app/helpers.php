<?php
namespace App\Helpers;
use App\Models\User;
use App\Models\Admin;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class Helper
{
    public static function getWebsite()
    {
        $w = Website::where("key", "main")->first();
        $s = Website::where("key", "socials")->first();
        $p = Website::where("key", "duitku_payment")->first();

        $web = $w ? json_decode($w->value, false) : null;
        $soc = $s ? json_decode($s->value, false) : null;
        $pay = $p ? json_decode($p->value, false) : null;

        return compact("web", "soc", "pay");
    }

    public static function getUserAuth()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);

        // return compact("user");
        return ["user" => $user];
    }

    public static function getAdminAuth()
    {
        $user_id = Auth::guard("adminMiddle")->user()->id;
        $user = Admin::find($user_id);

        // return compact("user");
        return ["user" => $user];
    }

    public static function escape_input($i = "")
    {
        return htmlspecialchars(strip_tags($i));
    }

    public static function website_config($i = "")
    {
        $check_data = Website::where("key", $i)->first();
        if ($check_data == false) {
            return false;
        }
        return json_decode($check_data->value);
    }

    public static function send_email($details = [], $subject = [], $view = "")
    {
        config([
            "mail.mailers.smtp.username" => self::website_config("smtp")
                ->username,
        ]);
        config([
            "mail.mailers.smtp.password" => self::website_config("smtp")
                ->password,
        ]);
        config([
            "mail.mailers.smtp.encryption" => self::website_config("smtp")
                ->encryption,
        ]);
        config([
            "mail.mailers.smtp.port" => self::website_config("smtp")->port,
        ]);
        config([
            "mail.mailers.smtp.host" => self::website_config("smtp")->host,
        ]);
        config(["mail.from.address" => self::website_config("smtp")->from]);
        config([
            "mail.from.name" => self::website_config("main")->website_name,
        ]);
        try {
            Mail::send($view, $details, function ($message) use (
                $details,
                $subject
            ) {
                $message
                    ->to(
                        $details["receiver"]["email"],
                        $details["receiver"]["name"]
                    )
                    ->from(
                        config("mail.from.address"),
                        config("mail.from.name")
                    )
                    ->subject($subject);
            });
            return [
                "result" => true,
            ];
        } catch (Exception $error) {
            return [
                "result" => false,
                "message" => $error->getMessage(),
            ];
        }
    }
}
