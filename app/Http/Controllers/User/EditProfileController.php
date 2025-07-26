<?php

namespace App\Http\Controllers\User;

use Helper;
use App\Models\Post;

//import Model "Post
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
//return type View
use Illuminate\Http\Request;

//return type redirectResponse
use App\Http\Controllers\Controller;

//import Facade "Storage"
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class EditProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get user data using the Helper method
        $user = Helper::getUserAuth();

        // Get additional data, such as website information, using the Helper method
        $website = Helper::getWebsite();

        // Merge user and website data into a single array
        $data = array_merge($user, $website);
        //render view with home
        return view("user.edit-profile", $data);
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
    public function edit()
    {
        // Get user data using the Helper method
        $user = Helper::getUserAuth();

        // Get additional data, such as website information, using the Helper method
        $website = Helper::getWebsite();

        // Merge user and website data into a single array
        $data = array_merge($user, $website);
        //render view with home
        return view("user.edit-profile", $data);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            "name" => "required",
            "username" => "required|unique:users,username," . $user->id,
            "email" => "required|email|unique:users,email," . $user->id,
            "profile_image" => "image|mimes:jpeg,png,jpg|max:2048",
        ]);

        $user->name = $request->input("name");
        $user->username = $request->input("username");
        $user->email = $request->input("email");

        if ($request->hasFile("profile_image")) {
            // Hapus foto profil yang lama
            Storage::delete("public/users-avatar/" . $user->avatar);

            // Simpan foto profil yang baru
            $imagePath = $request
                ->file("profile_image")
                ->store("public/users-avatar");
            $user->avatar = basename($imagePath);
        }

        $user->save();

        return redirect()
            ->route("profile.edit")
            ->with("success", "Profile updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            "current-password" => "required",
            "new-password" => "required|min:8",
        ]);

        $user = Auth::user();

        if (
            !Hash::check($request->input("current-password"), $user->password)
        ) {
            return back()->with(
                "errors",
                "Password saat ini tidak cocok dengan data kami."
            );
        }

        $user->password = Hash::make($request->input("new-password"));
        $user->save();

        return redirect()
            ->back()
            ->with("success", "Password berhasil diubah.");
    }
}
