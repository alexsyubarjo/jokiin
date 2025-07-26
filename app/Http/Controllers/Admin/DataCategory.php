<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Rule;

class DataCategory extends Controller
{
    public function __construct()
    {
        $this->middleware("adminMiddle");
    }

    public function index()
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $DataTabel = Categories::paginate(10);

        $data = array_merge($user, $website, [
            "page" => "Data Kategori",
            "DataTabel" => $DataTabel,
        ]);

        return view("admin.data-kategori", $data);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            "name" => ["required", "max:255", "unique:categories"],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Retrieve the kat data from the validated request
        $katData = $validator->validated();

        // Generate the slug from the name field
        $slug = Str::slug($katData["name"]);
        $katData["slug"] = $slug;

        $katData["description"] = $request->input("description");
        $katData["icon"] = $request->input("icon");

        // Create a new kat record
        $kat = Categories::create($katData);

        return redirect()
            ->back()
            ->with("success", "User data updated successfully");
    }

    public function update(Request $request)
    {
        // Retrieve the kat data from the request
        $katData = $request->only(["id", "name", "description", "icon"]);
        $slug = Str::slug($katData["name"]);
        $katData["slug"] = $slug;

        // Find the kat by ID
        $kat = Categories::find($katData["id"]);
        $kat->update($katData);

        // Redirect or return a response
        return redirect()
            ->back()
            ->with("success", "User data updated successfully");
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $kat = Categories::findOrFail($id);
        $kat->delete();

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }

    public function Ajax(Request $request)
    {
        $DataTabel = Categories::paginate(10);
        $partialView = view(
            "admin.partial.data-kategori",
            compact("DataTabel")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function get_data_kategori(Request $request)
    {
        $id = $request->input("id");

        $query = Categories::query();
        $kat = $query->where("id", $id)->first();

        // Return the partial view as JSON response
        return response()->json(["kat" => $kat]);
    }
}
