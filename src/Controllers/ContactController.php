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
use \App\Models\CompanyData;
use AporteWeb\Dashboard\Models\ContactRequest;
use Illuminate\Support\Facades\Mail;
use AporteWeb\Dashboard\Mail\ContactMessageMail;

class ContactController extends Controller {
    public function submit() {
        $config = CompanyData::first();
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$config->recaptcha_private_key."&response=".request()->recaptcha_token."&remoteip=".$_SERVER['REMOTE_ADDR']);
        $g_response = json_decode($response);
        if($g_response->success != true) {
            return ['status' => 'error'];
        }
        if (request()->type == 'contact-message' || request()->type == 'budget') {
            $message          = new ContactRequest;
            $message->name    = request()->name;
            $message->email   = request()->email;
            $message->phone   = request()->phone;
            $message->company = request()->company;
            $message->address = request()->address;
            $message->message = request()->message;
            $message->type    = request()->type;
            $message->save();
            $cart = json_decode(request()->cart, true);
            if (count($cart) && request()->type == 'budget') {
                $message->items()->createMany($cart);
            }
            Mail::to($config->email_system)->send(new ContactMessageMail(request()->all(), $cart));
        }
    }
    public function index($type) {
        $data = ContactRequest::where('type', $type)->paginate(20);
        return view('Dashboard::admin.contact.index', [
            'data'           => $data,
            'type'           => $type,
            '__admin_active' => 'admin.contact-'.$type
        ]);
    }
    public function show($type, $uuid) {
        $message = ContactRequest::where('type', $type)->where('uuid', $uuid)->first();
        return view('Dashboard::admin.contact.show', [
            'message'           => $message,
            '__admin_active' => 'admin.contact-'.$type
        ]);
    }
}
