<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use AporteWeb\Dashboard\Models\Chat;
use AporteWeb\Dashboard\Models\ChatMessage;
use AporteWeb\Dashboard\Models\Content;
use AporteWeb\Dashboard\Models\ContentMeta;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use AporteWeb\Dashboard\Models\Gallery;
use AporteWeb\Dashboard\Models\Multimedia;

class ChatAreaController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    public function getMessages() {
        $response = [];
        $chat = Chat::where('uuid', request()->uuid)->first();
        $response['chat'] = $chat;
        $user = auth()->user();
        if (request()->has('message')) {
            ChatMessage::create([
                'type'    => 'string',
                'content' => request()->message,
                'user_id' => $user->id,
                'chat_id' => $chat->id
            ]);
        } else {
            $messages = ChatMessage::where('chat_id', $chat->id)
                /*->select([
                    'id',
                    'content',
                    'type',
                    'user_id',
                    'uuid',
                ])*/
                ->get();
            $response['messages'] = $messages;
        }
        return response()->json($response);
    }
}
