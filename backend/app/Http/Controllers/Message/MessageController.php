<?php
namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Jobs\SendMessage;
use App\Models\User\User;
use App\Repositories\Message\MessageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function index()
    {
        return view('chat.all-chats');
    }

    public function view()
    {
        $user = User::where('id', auth()->id())->select(['id', 'name', 'email'])->first();
        return view('chat.global-chat', ['user' => $user]);
    }

    public function viewPrivate()
    {
        $user = User::where('id', auth()->id())->select(['id', 'name', 'email'])->first();
        return view('chat.private-chat', ['user' => $user]);
    }

    public function getActiveChats()
    {
        $userId = Auth::id();
        $activeChats = $this->messageRepository->getUserActiveChats($userId);
        return response()->json($activeChats);
    }

    public function getPrivateMessages($receiverId)
    {
        $authUserId = Auth::id();
        $messages = $this->messageRepository->getPrivateMessages($authUserId, $receiverId);
        return response()->json($messages);
    }

    public function messages()
    {
        $messages = $this->messageRepository->getGlobalMessages();
        return response()->json($messages);
    }

    public function message(Request $request)
    {
        $message = $this->messageRepository->sendMessage($request->only(['user_id', 'text', 'receiver_id']));
        SendMessage::dispatch($message);

        return response()->json([
            'success' => true,
            'message' => "Message created and job dispatched.",
        ]);
    }
}
