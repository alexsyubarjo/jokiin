<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\UserActivateAccount;
use App\Http\Controllers\Controller;

class DataPengguna extends Controller
{
    public function __construct()
    {
        $this->middleware("adminMiddle");
    }

    public function index()
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $DataTabel = User::whereNotNull("email_verified_at")->paginate(10);

        $data = array_merge($user, $website, [
            "page" => "Data Pengguna",
            "DataTabel" => $DataTabel,
        ]);

        return view("admin.data-user", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Retrieve the user data from the request
        $userData = $request->only([
            "id",
            "name",
            "username",
            "email",
            "nomor_hp",
            "saldo",
            "saldo_employer",
        ]);

        // Find the user by ID
        $user = User::find($userData["id"]);

        // Update the non-password fields
        $user->update($userData);

        // Update the password field only if there is an input value
        $password = $request->input("password");
        if (!empty($password)) {
            $user->password = bcrypt($password);
            $user->save();
        }

        // Redirect or return a response
        return redirect()
            ->back()
            ->with("success", "User data updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */

    public function verifikasi(Request $request)
    {
        $id = $request->input("id");
        $user = User::findOrFail($id);
        $user->update([
            "email_verified_at" => Carbon::now(),
        ]);

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $user = User::findOrFail($id);
        $user->delete();
        UserActivateAccount::where("email", $user->email)->delete();

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }

    public function user_verifikasi()
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $DataTabel = User::whereNull("email_verified_at")->paginate(10);

        $data = array_merge($user, $website, [
            "page" => "User Verifikasi",
            "DataTabel" => $DataTabel,
        ]);

        return view("admin.data-user", $data);
    }

    public function Ajax(Request $request)
    {
        $url = $request->input("url");
        if ($url == "data-pengguna") {
            $DataTabel = User::whereNotNull("email_verified_at")->paginate(10);
        } elseif ($url == "user-verifikasi") {
            $DataTabel = User::whereNull("email_verified_at")->paginate(10);
        }

        $partialView = view(
            "admin.partial.data-pengguna",
            compact("DataTabel")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function get_data_user(Request $request)
    {
        $id = $request->input("id");

        $query = User::query();
        $user = $query->where("id", $id)->first();

        // Return the partial view as JSON response
        return response()->json(["user" => $user]);
    }
}
