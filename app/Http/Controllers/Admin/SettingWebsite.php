<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SettingWebsite extends Controller
{
    public function __construct()
    {
        $this->middleware("adminMiddle");
    }

    public function index()
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $data = array_merge($user, $website, [
            "page" => "Setting Utama",
        ]);

        return view("admin.setting-utama", $data);
    }

    public function setting_logo()
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $data = array_merge($user, $website, [
            "page" => "Setting Logo & Favicon",
        ]);

        return view("admin.setting-logo", $data);
    }

    public function media_sosial()
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $data = array_merge($user, $website, [
            "page" => "Setting Media Sosial",
        ]);

        return view("admin.setting-sosmed", $data);
    }

    public function smtp_email()
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $s = Website::where("key", "smtp")->first();
        $smtp = $s ? json_decode($s->value, false) : null;

        $data = array_merge($user, $website, [
            "page" => "Setting SMTP Email",
            "smtp" => $smtp,
        ]);

        return view("admin.setting-smtp-email", $data);
    }

    public function payment()
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $data = array_merge($user, $website, [
            "page" => "Setting Payment",
        ]);

        return view("admin.setting-payment", $data);
    }

    public function lain_lain()
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $data = array_merge($user, $website, [
            "page" => "Setting Lain-lain",
        ]);

        return view("admin.setting-lain-lain", $data);
    }

    // Update controller

    public function update_utama(Request $request)
    {
        $web = Website::where("key", "main")->first();
        if ($web) {
            $value = json_decode($web->value, true); // Decode JSON data into an array

            // Update the values based on the desired keys
            $value["website_name"] = $request->input("nama");
            $value["meta_keywords"] = $request->input("keyword");
            $value["meta_description"] = $request->input("deskripsi");
            $value["min_wd"] = $request->input("min_wd");
            $value["wd"] = $request->input("wd");

            $web->update(["value" => json_encode($value)]);

            return redirect()
                ->back()
                ->with("success", "Data successfully updated");
        } else {
            return redirect()
                ->back()
                ->with("error", 'Website data with key "main" not found');
        }
    }

    public function update_about_us(Request $request)
    {
        $web = Website::where("key", "main")->first();
        if ($web) {
            $value = json_decode($web->value, true); // Decode JSON data into an array

            // Update the values based on the desired keys
            $value["about_us"] = $request->input("about_us");

            $web->update(["value" => json_encode($value)]);

            return redirect()
                ->back()
                ->with("success", "Data successfully updated");
        } else {
            return redirect()
                ->back()
                ->with("error", 'Website data with key "main" not found');
        }
    }

    public function update_logo(Request $request)
    {
        $web = Website::where("key", "main")->first();

        if ($web) {
            $value = json_decode($web->value, true);

            $this->validate($request, [
                "image" => "required|file|mimes:jpeg,jpg,png,svg|max:5048",
            ]);

            $image = $request->file("image");
            $imageName = $image->hashName();

            if (isset($value["website_logo"])) {
                // Hapus gambar lama jika ada
                Storage::delete("public/images/logo/" . $value["website_logo"]);
            }

            $image->storeAs("public/images/logo", $imageName);

            $value["website_logo"] = $imageName;
            $web->update(["value" => json_encode($value)]);

            return redirect()
                ->back()
                ->with("success", "Data berhasil diperbarui");
        } else {
            return redirect()
                ->back()
                ->with(
                    "error",
                    'Data website dengan key "main" tidak ditemukan'
                );
        }
    }

    public function update_logo_fav(Request $request)
    {
        $web = Website::where("key", "main")->first();

        if ($web) {
            $value = json_decode($web->value, true);

            $this->validate($request, [
                "image" => "required|file|mimes:jpeg,jpg,png,svg|max:5048",
            ]);

            $image = $request->file("image");
            $imageName = $image->hashName();

            if (isset($value["website_favicon"])) {
                // Hapus gambar lama jika ada
                Storage::delete("public/images/" . $value["website_favicon"]);
            }

            $image->storeAs("public/images", $imageName);

            $value["website_favicon"] = $imageName;
            $web->update(["value" => json_encode($value)]);

            return redirect()
                ->back()
                ->with("success", "Data berhasil diperbarui");
        } else {
            return redirect()
                ->back()
                ->with(
                    "error",
                    'Data website dengan key "main" tidak ditemukan'
                );
        }
    }

    public function update_sosmed(Request $request)
    {
        $web = Website::where("key", "socials")->first();
        if ($web) {
            $value = json_decode($web->value, true); // Decode JSON data into an array

            // Update the values based on the desired keys
            $value["facebook"] = stripslashes($request->input("facebook"));
            $value["instagram"] = stripslashes($request->input("instagram"));
            $value["whatsapp"] = $request->input("whatsapp");
            $value["telegram"] = $request->input("telegram");
            $value["twitter"] = stripslashes($request->input("twitter"));
            $value["youtube"] = stripslashes($request->input("youtube"));
            $value["tiktok"] = stripslashes($request->input("tiktok"));

            $web->update(["value" => json_encode($value)]);

            return redirect()
                ->back()
                ->with("success", "Data successfully updated");
        } else {
            return redirect()
                ->back()
                ->with("error", 'Website data with key "main" not found');
        }
    }

    public function update_payment(Request $request)
    {
        $web = Website::where("key", "duitku_payment")->first();
        if ($web) {
            $value = json_decode($web->value, true); // Decode JSON data into an array

            // Update the values based on the desired keys
            $value["merchant_code"] = stripslashes(
                $request->input("merchant_code")
            );
            $value["status"] = $request->input("status");
            $value["api_key"] = stripslashes($request->input("api_key"));
            $value["private_key"] = $request->input("private_key");
            $value["mode"] = $request->input("mode");

            $web->update(["value" => json_encode($value)]);

            return redirect()
                ->back()
                ->with("success", "Data successfully updated");
        } else {
            return redirect()
                ->back()
                ->with("error", 'Website data with key "main" not found');
        }
    }

    public function update_smtp_email(Request $request)
    {
        $web = Website::where("key", "smtp")->first();
        if ($web) {
            $value = json_decode($web->value, true); // Decode JSON data into an array

            // Update the values based on the desired keys
            $value["host"] = $request->input("host");
            $value["port"] = $request->input("port");
            $value["encryption"] = $request->input("encryption");
            $value["from"] = $request->input("from");
            $value["auth"] = $request->input("auth");
            $value["username"] = $request->input("username");
            $value["password"] = $request->input("password");
            $value["email_aktivasi"] = $request->input("email_aktivasi");

            $web->update(["value" => json_encode($value)]);

            return redirect()
                ->back()
                ->with("success", "Data successfully updated");
        } else {
            return redirect()
                ->back()
                ->with("error", 'Website data with key "main" not found');
        }
    }

    public function update_lain_lain(Request $request)
    {
        $web = Website::where("key", "main")->first();
        if ($web) {
            $value = json_decode($web->value, true); // Decode JSON data into an array

            // Update the values based on the desired keys=
            $value["terms"] = $request->input("terms");

            $web->update(["value" => json_encode($value)]);

            return redirect()
                ->back()
                ->with("success", "Data successfully updated");
        } else {
            return redirect()
                ->back()
                ->with("error", 'Website data with key "main" not found');
        }
    }

    public function update_lain_lain_privacy(Request $request)
    {
        $web = Website::where("key", "main")->first();
        if ($web) {
            $value = json_decode($web->value, true); // Decode JSON data into an array

            // Update the values based on the desired keys=
            $value["privacy"] = $request->input("privacy");

            $web->update(["value" => json_encode($value)]);

            return redirect()
                ->back()
                ->with("success", "Data successfully updated");
        } else {
            return redirect()
                ->back()
                ->with("error", 'Website data with key "main" not found');
        }
    }

    public function test_email()
    {
        if (
            website_config("smtp")->host == "" ||
            website_config("smtp")->port == "" ||
            website_config("smtp")->from == "" ||
            website_config("smtp")->encryption == ""
        ) {
            return redirect()
                ->back()
                ->with("result", [
                    "alert" => "danger",
                    "title" => "Gagal",
                    "message" => "Mohon untuk bidang melengkapi SMTP.",
                ]);
        }
        config([
            "mail.mailers.smtp.username" => website_config("smtp")->username,
        ]);
        config([
            "mail.mailers.smtp.password" => website_config("smtp")->password,
        ]);
        config([
            "mail.mailers.smtp.encryption" => website_config("smtp")
                ->encryption,
        ]);
        config(["mail.mailers.smtp.port" => website_config("smtp")->port]);
        config(["mail.mailers.smtp.host" => website_config("smtp")->host]);
        config(["mail.from.address" => website_config("smtp")->from]);
        config(["mail.from.name" => website_config("main")->website_name]);
        try {
            Mail::raw(website_config("main")->website_name, function (
                $message
            ) {
                $message
                    ->to(website_config("smtp")->from)
                    ->from(
                        config("mail.from.address"),
                        config("mail.from.name")
                    )
                    ->subject("Tes SMTP Email");
            });
            return redirect()
                ->back()
                ->with("result", [
                    "alert" => "success",
                    "title" => "Berhasil",
                    "message" =>
                        "Silahkan periksa Email: " .
                        website_config("smtp")->from .
                        ".",
                    "timeout" => 30000,
                    "size" => "col-lg-12",
                ]);
        } catch (Exception $message) {
            return redirect()
                ->back()
                ->with("result", [
                    "alert" => "danger",
                    "title" => "Gagal",
                    "message" => $message->getMessage(),
                ]);
        }
    }
}
