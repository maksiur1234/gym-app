<?php
namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Jobs\SendMessage;
use App\Models\Message\Message;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function view()
    {
        $user = User::where('id', auth()->id())->select([
            'id', 'name', 'email',
        ])->first();

        return view('chat.global-chat', ['user' => $user]);
    }

    public function privateChat($trainerId)
    {
        return view('chat.private-chat', ['trainerId' => $trainerId]);
    }

    public function index()
    {
        return view('chat.all-chats');
    }

    public function messages()
    {
        $messages = Message::with('user')->get()->append('time');

        return response()->json($messages);
    }

    public function message(Request $request)
    {
        $message = Message::create([
            'user_id' => $request->user_id,
            'text' => $request->text,
            'time' => now(),
        ]);

        SendMessage::dispatch($message);

        return response()->json([
            'success' => true,
            'message' => "Message created and job dispatched.",
        ]);
    }
}
