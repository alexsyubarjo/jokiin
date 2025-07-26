<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function sender()
    {
        return $this->belongsTo(User::class, "sender_id");
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, "receiver_id");
    }
    public static function getContactList()
    {
        $user_id = Auth::id();

        $senderContacts = self::where("receiver_id", $user_id)
            ->distinct()
            ->pluck("sender_id");

        $receiverContacts = self::where("sender_id", $user_id)
            ->distinct()
            ->pluck("receiver_id");

        $contactIds = $senderContacts->concat($receiverContacts)->unique();

        $contacts = User::whereIn("id", $contactIds)->get();

        $latestMessages = self::whereIn("sender_id", $contactIds)
            ->orWhereIn("receiver_id", $contactIds)
            ->orderBy("created_at", "desc")
            ->get();

        $contacts = $contacts->map(function ($contact) use ($latestMessages) {
            $contact->latestMessage = $latestMessages
                ->filter(function ($message) use ($contact) {
                    return $message->sender_id == $contact->id ||
                        $message->receiver_id == $contact->id;
                })
                ->sortByDesc("created_at")
                ->first();

            $contact->unseen_message_count = self::where("seen", 1)
                ->whereNot("sender_id", Auth::id())
                ->where(function ($query) use ($contact) {
                    $query
                        ->where(function ($q) use ($contact) {
                            $q->where("sender_id", $contact->id)->where(
                                "receiver_id",
                                Auth::id()
                            );
                        })
                        ->orWhere(function ($q) use ($contact) {
                            $q->where("sender_id", Auth::id())->where(
                                "receiver_id",
                                $contact->id
                            );
                        });
                })
                ->count();

            return $contact;
        });

        // Ambil ID pesan dan tambahkan ke koleksi kontak
        $contacts = $contacts->map(function ($contact) {
            $contact->message_id = $contact->latestMessage
                ? $contact->latestMessage->id
                : null;
            return $contact;
        });

        return $contacts;
    }
}
