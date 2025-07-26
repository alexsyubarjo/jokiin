<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Models\Post;
use App\Models\DataRepot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataJobs extends Controller
{
    public function __construct()
    {
        $this->middleware("adminMiddle");
    }

    public function index(Request $request)
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $DataTabel = Post::with("user")->paginate(10);

        $data = array_merge($user, $website, [
            "page" => "Data Jobs",
            "DataTabel" => $DataTabel,
        ]);

        return view("admin.data-jobs", $data);
    }

    public function Ajax(Request $request)
    {
        $DataTabel = Post::with("user")->paginate(10);

        $partialView = view(
            "admin.partial.data-jobs",
            compact("DataTabel")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function data_repot(Request $request)
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $DataTabel = Post::with(["user", "data_repot"])->paginate(10);

        $data = array_merge($user, $website, [
            "page" => "Data Repot",
            "DataTabel" => $DataTabel,
        ]);

        return view("admin.data-repot", $data);
    }

    public function data_repot_Ajax(Request $request)
    {
        $DataTabel = Post::with("user")->paginate(10);

        $partialView = view(
            "admin.partial.data-repot",
            compact("DataTabel")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function data_repot_modal_Ajax(Request $request)
    {
        $id = $request->input("id");
        $DataTabel = DataRepot::with("user")
            ->where("post_id", $id)
            ->get();

        $partialView = view(
            "admin.partial.data-repot-modal",
            compact("DataTabel")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function update_status(Request $request)
    {
        $id = $request->input("id");
        $status = $request->input("status");
        $data = Post::findOrFail($id);
        $data->update([
            "status" => $status,
        ]);

        return redirect()
            ->back()
            ->with("success", "Status data updated successfully");
    }

    public function get_data_post(Request $request)
    {
        $id = $request->input("id");

        $query = Post::query();
        $post = $query->where("id", $id)->first();

        // Return the partial view as JSON response
        return response()->json(["post" => $post]);
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $data = Post::findOrFail($id);
        $data->delete();

        $repot = DataRepot::where("post_id", $id)->first();
        if ($repot) {
            $repot->delete();
        }

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }
}
