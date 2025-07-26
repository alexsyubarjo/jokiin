<?php

namespace App\Http\Controllers\User;

use Helper;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $user_id = Auth::id();
        $user = Helper::getUserAuth();
        $website = Helper::getWebsite();

        $latestMessages = Message::getContactList();

        $data = array_merge($user, $website, [
            "messages" => $latestMessages,
        ]);
        return view("user.message", $data);
    }

    public function create()
    {
        // return view("messages.create");
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            "reply" => "required",
            "images" => "file|mimes:jpeg,png,jpg|max:2048", // Ubah sesuai dengan kebutuhan Anda
        ]);

        // Simpan pesan baru
        $message = new Message();
        $message->sender_id = Auth::id();
        $message->receiver_id = $request->input("sender_id");
        $message->content = $request->input("reply");
        $message->seen = 1;

        if ($request->hasFile("images")) {
            $file = $request->file("images");
            $extension = $file->getClientOriginalExtension();
            $filename = Str::random(40) . "." . $extension;
            $path = $file->storeAs("public/chat", $filename);
            $message->image = $filename;
        }

        $message->save();

        if ($request->ajax()) {
            return response()->json(["success" => true]);
        } else {
            return redirect("dashboard/pesan")->with(
                "success",
                "Pesan berhasil dikirim."
            );
        }
    }

    public function show($id)
    {
        // $message = Message::findOrFail($id);
        // return view("messages.show", compact("message"));
    }

    public function edit($id)
    {
        // $message = Message::findOrFail($id);
        // return view("messages.edit", compact("message"));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            "receiver_id" => "required|exists:users,id",
            "content" => "required|string",
        ]);

        $message = Message::findOrFail($id);
        $message->receiver_id = $validatedData["receiver_id"];
        $message->content = $validatedData["content"];
        $message->save();

        return redirect()
            ->route("pesan.index")
            ->with("success", "Pesan berhasil diperbarui.");
    }

    public function destroy(Request $request)
    {
        $sen = $request->input("sen");
        $rec = $request->input("rec");

        Message::where(function ($query) use ($sen, $rec) {
            $query->where("sender_id", $sen)->where("receiver_id", $rec);
        })
            ->orWhere(function ($query) use ($sen, $rec) {
                $query->where("sender_id", $rec)->where("receiver_id", $sen);
            })
            ->get()
            ->each(function ($message) {
                if ($message->image) {
                    Storage::disk("public")->delete("chat/" . $message->image);
                }
                $message->delete();
            });

        return response()->json([
            "success" => true,
            "message" => "Aksi berhasil dilakukan.",
        ]);
    }

    public function chatAjax(Request $request)
    {
        $user_id = Auth::id();
        $senId = $request->input("id_sen");
        $recId = $request->input("id_rec");

        $messages = Message::with(["sender", "receiver"])
            ->select(
                "messages.*",
                DB::raw(
                    "CASE WHEN messages.sender_id = {$senId} THEN messages.content ELSE NULL END as sender_content"
                ),
                DB::raw(
                    "CASE WHEN messages.receiver_id = {$recId} THEN messages.content ELSE NULL END as receiver_content"
                )
            )
            ->join("users as sender", "messages.sender_id", "=", "sender.id")
            ->join(
                "users as receiver",
                "messages.receiver_id",
                "=",
                "receiver.id"
            )
            ->where(function ($query) use ($senId, $recId) {
                $query
                    ->where(function ($q) use ($senId, $recId) {
                        $q->where("sender_id", $senId)->where(
                            "receiver_id",
                            $recId
                        );
                    })
                    ->orWhere(function ($q) use ($senId, $recId) {
                        $q->where("sender_id", $recId)->where(
                            "receiver_id",
                            $senId
                        );
                    });
            })
            ->orderBy("id", "asc")
            ->get();

        $partialView = View::make(
            "user.partial.chat-load",
            compact("messages")
        )->render();

        Message::where("sender_id", $senId)
            ->where("receiver_id", $user_id)
            ->update(["seen" => 0]);

        $data_m = $messages->first();

        $other_user_id =
            $data_m->sender_id != $user_id
                ? $data_m->sender_id
                : $data_m->receiver_id;

        $nama =
            $data_m->sender_id != $user_id
                ? $data_m->sender->name
                : $data_m->receiver->name;

        $avatar =
            $data_m->sender_id != $user_id
                ? $data_m->sender->avatar
                : $data_m->receiver->avatar;

        $clas = Cache::has("user-online" . $other_user_id) ? "" : "busy";

        if ($avatar) {
            $img =
                '<img src="' .
                asset("storage/users-avatar/" . $avatar) .
                '" alt="#">';
        } else {
            $img =
                '<img src="' .
                asset("storage/images/default.jpg") .
                '" alt="#">';
        }

        $label =
            ' <div class="image ' .
            $clas .
            '">
                            ' .
            $img .
            '
                        </div>
                        <h3 class="username-title fw-bold">
                            ' .
            $nama .
            '
                        </h3>';

        return response()->json([
            "partialView" => $partialView,
            "label" => $label,
            "senId" => $senId,
        ]);
    }
}
