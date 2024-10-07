<?php
namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Models\Message\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index($receiverId)
    {
        $messages = Message::where(function ($query) use ($receiverId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        return view('chat.chat', compact('messages', 'receiverId'));
    }

    public function store(Request $request)
    {
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return redirect()->route('chat.show', $request->receiver_id);
    }
}
