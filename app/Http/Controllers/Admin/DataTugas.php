<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Models\Logs;
use App\Models\Post;
use App\Models\User;
use App\Models\Tugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataTugas extends Controller
{
    public function __construct()
    {
        $this->middleware("adminMiddle");
    }

    public function index(Request $request)
    {
        $user = Helper::getAdminAuth();
        $website = Helper::getWebsite();

        $DataTabel = Tugas::with("post", "user")
            ->distinct()
            ->paginate(10);

        $data = array_merge($user, $website, [
            "page" => "Data Tugas",
            "DataTabel" => $DataTabel,
        ]);

        return view("admin.data-tugas", $data);
    }

    public function Ajax(Request $request)
    {
        // $url = $request->input("url");

        $DataTabel = Tugas::with("post", "user")
            ->distinct()
            ->paginate(10);

        $partialView = view(
            "admin.partial.data-tugas",
            compact("DataTabel")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }

    public function modalAjax(Request $request)
    {
        $id = $request->input("id");

        $query = Tugas::query();
        $post = $query->where("id", $id)->first();
        $Tugas = $post ? json_decode($post->bukti, true) : null;

        $partialView = view(
            "user.partial.file-bukti",
            compact("Tugas")
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

        $tugas = Tugas::find($id);

        $tugas->update([
            "status" => $status,
        ]);
        if ($status == "1") {
            $post = Post::where("id", $tugas->post_id)->first();
            $user = User::where("id", $tugas->user_id)->first();
            $employer = User::where("id", $post->user_id)->first();

            if ($user->saldo_employer < $post->komisi) {
                return redirect()
                    ->back()
                    ->with("danger", "Saldo Employer tidak mencukupi.");
            }

            $logs = new Logs();
            $logs->user_id = $user->id;
            $logs->log_info =
                "Kamu mendapatkan <b>" .
                $post->komisi .
                "</b> dari Tugas <b>" .
                $post->title .
                "</b>";
            $logs->status = "Sukses";
            $logs->save();

            $user->update([
                "saldo" => $user->saldo + $post->komisi,
            ]);
            $employer->update([
                "saldo_employer" => $user->saldo_employer - $post->komisi,
            ]);
        }

        return redirect()
            ->back()
            ->with("success", "Status data updated successfully");
    }

    public function get_data_tugas(Request $request)
    {
        $id = $request->input("id");

        $query = Tugas::query();
        $tugas = $query->where("id", $id)->first();

        // Return the partial view as JSON response
        return response()->json(["tugas" => $tugas]);
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $data = Tugas::findOrFail($id);
        $data->delete();

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }
}
