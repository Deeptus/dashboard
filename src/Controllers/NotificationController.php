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
use AporteWeb\Dashboard\Models\Homework;
use AporteWeb\Dashboard\Models\User;
use Junges\ACL\Models\Group;

class NotificationController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    public function all() {
        // $notifications = auth()->user()->unreadNotifications;
        $notifications = auth()->user()->notifications;
        $notifications->each(function ($item, $key) {
            $item->created_at_ago = $item->created_at->ago();
        });
        // auth()->user()->unreadNotifications->markAsRead();
        return $notifications;
    }
    public function find() {
        $notification = \Illuminate\Notifications\DatabaseNotification::find(request()->id);
        if ($notification) {
            $notification->markAsRead();
            // Despues se asigna el created_at_ago porque si no da error el markAsRead,
            // porque intenta guardar created_at_ago cuando no existe
            $notification->created_at_ago = $notification->created_at->ago();
            return $notification;
        }
        return null;
    }
}
