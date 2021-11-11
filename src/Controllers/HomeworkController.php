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

class HomeworkController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        return view('Dashboard::admin.homework.index', [
            '__admin_active' => 'admin.homework.index'
        ]);
    }
    public function myTasks() {
        $homework = User::find(auth()->user()->id)->homework()->orderBy('id', 'desc')->get()->append(['start_at_formated', 'user_name', 'created_at_ago']);
        return $homework;
    }
    public function data() {
        return [
            'records' => Homework::get()->each->append(['user_name', 'users_state', 'created_at_ago']),
            'users'   => User::get(['id', 'username']),
            'groups'  => Group::get(['id', 'name']),
        ];
    }
    public function save() {
        $item             = new Homework;
        $item->title      = request()->title;
        $item->details    = request()->details;
        $item->individual = request()->individual;
        $item->start_at   = request()->start_at;
        $item->finish_at  = request()->finish_at;
        $item->user_id    = auth()->user()->id;
        $item->save();
        $users = json_decode(request()->users);
        $item->users()->sync($users);
    }
    public function find() {
        $homework = Homework::where('uuid', request()->uuid)->first()->append(['user_name', 'created_at_ago', 'start_at_formated']);
        $user     = auth()->user();
        $pivot    = DB::select('SELECT * FROM homework_user WHERE homework_id = :homework_id AND user_id = :user_id', [ 'homework_id' => $homework->id, 'user_id' => $user->id ]);
        
        // for test: UPDATE `homework_user` SET `read_at`=null WHERE `homework_id`=1 AND `user_id`=1
        if (is_array($pivot) && count($pivot) > 0 && !$pivot[0]->read_at) {
            $homework->users()->updateExistingPivot(auth()->user(), array('read_at' => now()), false);
        }

        return $homework;
    }
}
