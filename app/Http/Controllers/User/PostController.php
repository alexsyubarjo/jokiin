<?php

namespace App\Http\Controllers\User;

use Helper;
use App\Models\Post;
use Illuminate\View\View;
use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index(Request $request)
    {
        $user_id = Auth::id();
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $posts = Post::with("category")
            ->select(
                "posts.id",
                "posts.jumlah",
                "posts.title as post_title",
                "posts.slug",
                "posts.content as post_content",
                "posts.image",
                "posts.status",
                "categories.name as category",
                DB::raw(
                    "COUNT(CASE WHEN tugas.status = 1 THEN 1 ELSE NULL END) as total"
                )
            )
            ->join("categories", "categories.id", "=", "posts.category_id")
            ->leftJoin("tugas", function ($join) {
                $join
                    ->on("posts.id", "=", "tugas.post_id")
                    ->where("tugas.status", "=", 1);
            })
            ->where("posts.user_id", "=", $user_id)
            ->orderBy("posts.id", "desc")
            ->groupBy(
                "posts.id",
                "posts.jumlah",
                "posts.title",
                "posts.slug",
                "posts.content",
                "posts.image",
                "posts.status",
                "categories.name"
            )
            ->paginate(5);

        $data = [
            "postsItems" => $posts,
        ];

        $data = array_merge($user, $website, $data);

        return view("user.employer.data-tugas", $data);
    }

    public function create(): View
    {
        $user_id = Auth::id();
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $kategori = Categories::orderBy("name", "asc")->get();

        $data = array_merge($user, $website, [
            "kategori" => $kategori,
        ]);
        //render view with home
        return view("user.employer.post-add", $data);
    }

    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            "image" => "required|image|mimes:jpeg,jpg,png|max:5048",
            "title" => "required|min:5",
            "kategori" => "required",
            "jumlah" => "required",
            "komisi" => "required",
            "content" => "required|min:10",
            "form_bukti.*" => "required",
        ]);

        $jum = str_replace(".", "", $request->jumlah);
        $kom = str_replace(".", "", $request->komisi);

        // Generate initial slug
        $slug = Str::slug($request->title);

        // Check if the slug already exists in the database
        $count = Post::where("slug", $slug)->count();
        $uniqueSlug = $count > 0 ? $slug . "-" . ($count + 1) : $slug;

        $jsonData = [];
        $formBukti = $request->form_bukti;

        foreach ($formBukti as $key => $value) {
            $jsonKey = "proof" . ($key + 1);
            $jsonData[$jsonKey] = $value;
        }
        $jsonString = json_encode($jsonData);

        // upload image
        $image = $request->file("image");
        $image->storeAs("public/posts", $image->hashName());

        // create post
        Post::create([
            "category_id" => $request->kategori,
            "user_id" => Auth::id(),
            "image" => $image->hashName(),
            "title" => $request->title,
            "slug" => $uniqueSlug, // Use the unique slug
            "content" => $request->content,
            "jumlah" => $jum,
            "komisi" => $kom,
            "nama_file_form" => $jsonString,
            "status" => "Berjalan",
        ]);

        //redirect to index
        return redirect()
            ->route("posts.index")
            ->with(["success" => "Data Berhasil Disimpan!"]);
    }

    public function show(string $id): View
    {
        //get post by ID
        $post = Post::findOrFail($id);

        //render view with post
        return view("posts.show", compact("post"));
    }

    public function edit(string $id): View
    {
        $id = Crypt::decrypt($id);
        $user_id = Auth::id();
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $post = Post::where("user_id", $user_id)->findOrFail($id);
        $kategori = Categories::orderBy("name", "asc")->get();

        $file_form = json_decode($post->nama_file_form, true);

        $data = array_merge($user, $website, [
            "post" => $post,
            "kategori" => $kategori,
            "file_form" => $file_form,
        ]);
        //render view with home
        return view("user.employer.post-edit", $data);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $jum = str_replace(".", "", $request->jumlah);
        $kom = str_replace(".", "", $request->komisi);
        $slug = Str::slug($request->title);
        $count = Post::where("slug", $slug)
            ->where("id", "<>", $id)
            ->count();
        if ($count > 0) {
            $slug = $slug . "-" . ($count + 1); // You can use any number or logic you prefer
        }

        $jsonData = [];
        $formBukti = $request->form_bukti;

        foreach ($formBukti as $key => $value) {
            $jsonKey = "proof" . ($key + 1);
            $jsonData[$jsonKey] = $value;
        }
        $jsonString = json_encode($jsonData);

        // Get post by ID
        $post = Post::findOrFail($id);

        // Update post data
        $postData = [
            "category_id" => $request->kategori,
            "user_id" => Auth::id(),
            "title" => $request->title,
            "slug" => $slug,
            "content" => $request->content,
            "jumlah" => $jum,
            "komisi" => $kom,
            "nama_file_form" => $jsonString,
            "status" => "Berjalan",
        ];

        // Check if image is uploaded
        if ($request->hasFile("image")) {
            $this->validate($request, [
                "image" => "required|image|mimes:jpeg,jpg,png|max:5048",
            ]);

            // Upload new image
            $image = $request->file("image");
            $image->storeAs("public/posts", $image->hashName());

            // Delete old image
            Storage::delete("public/posts/" . $post->image);

            // Update post with new image
            $postData["image"] = $image->hashName();
        }

        // Update post
        $post->update($postData);

        // Redirect to index
        return redirect()
            ->route("posts.index")
            ->with(["success" => "Data Berhasil Diubah!"]);
    }

    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $post = Post::findOrFail($id);

        //delete image
        Storage::delete("public/posts/" . $post->image);

        //delete post
        $post->delete();

        //redirect to index
        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }

    public function paginationAjax(Request $request)
    {
        $user_id = Auth::id();

        $postsItems = $posts = Post::with("category")
            ->select(
                "posts.id",
                "posts.jumlah",
                "posts.title as post_title",
                "posts.slug",
                "posts.content as post_content",
                "posts.image",
                "posts.status",
                "categories.name as category",
                DB::raw(
                    "COUNT(CASE WHEN tugas.status = 1 THEN 1 ELSE NULL END) as total"
                )
            )
            ->join("categories", "categories.id", "=", "posts.category_id")
            ->leftJoin("tugas", function ($join) {
                $join
                    ->on("posts.id", "=", "tugas.post_id")
                    ->where("tugas.status", "=", 1);
            })
            ->where("posts.user_id", "=", $user_id)
            ->orderBy("posts.id", "desc")
            ->groupBy(
                "posts.id",
                "posts.jumlah",
                "posts.title",
                "posts.slug",
                "posts.content",
                "posts.image",
                "posts.status",
                "categories.name"
            )
            ->paginate(5);

        $partialView = view(
            "user.partial.data-tugas-load",
            compact("postsItems")
        )->render();

        // Return the partial view as JSON response
        return response()->json([
            "partialView" => $partialView,
        ]);
    }
}
