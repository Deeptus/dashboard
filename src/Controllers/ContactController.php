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
use AporteWeb\Dashboard\Models\ContactRequestItems;
use AporteWeb\Dashboard\Models\ContactRequestFile;
use Illuminate\Support\Facades\Mail;

use AporteWeb\Dashboard\Mail\ContactMessageMail;

class ContactController extends Controller {
    public function submit() {
        $config = CompanyData::first();
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$config->recaptcha_private_key."&response=".request()->recaptcha_token."&remoteip=".$_SERVER['REMOTE_ADDR']);
        $g_response = json_decode($response);
        if($g_response->success != true) {
            return [
                'status'  => 'error',
                'message' => 'El reCAPTCHA no es válido.'
            ];
        }

        if (request()->type == 'custom-component') {
            // verif request()->component content only contains letters, numbers, dashes and underscores
            if (!preg_match('/^[a-zA-Z0-9_-]+$/', request()->component)) {
                return [
                    'status'  => 'error',
                    'message' => 'El componente no es válido.'
                ];
            }
            $className = "\\App\\Dashboard\\Components\\" . request()->component;          
            $component = new $className;
            $component->store();
        }

        if (request()->type == 'contact-message' || request()->type == 'budget' || request()->type == 'shopping-cart') {
            $message            = new ContactRequest;
            $message->name      = request()->name;
            $message->email     = request()->email;
            $message->phone     = request()->phone;
            $message->company   = request()->company;
            $message->address   = request()->address;
            $message->message   = request()->message;
            $message->type      = request()->type;
            $message->provincia = request()->provincia;
            $message->localidad = request()->localidad;
            $message->direccion = request()->direccion;
            $message->save();
            $cart = json_decode(request()->cart, true);
            if (count($cart) && (request()->type == 'budget' || request()->type == 'shopping-cart')) {
                $message->items()->createMany($cart);
            }
            $uploads = [];
            if(request()->has('files')){
                foreach (request()->file('files') as $key => $file) {
                    $uploads[] = [
                        'path'          => $file->store('public/public-uploads'),
                        'original_name' => $file->getClientOriginalName()
                    ];
                }
                $message->files()->createMany($uploads);
            }
            Mail::to($config->email_system)->send(new ContactMessageMail($message, $cart, $uploads, [
                'name' => [
                    'type' => 'text',
                    'label' => 'Nombre',
                ],
                'email' => [
                    'type' => 'text',
                    'label' => 'Email',
                ],
                'phone' => [
                    'type' => 'text',
                    'label' => 'Teléfono',
                ],
                'company' => [
                    'type' => 'text',
                    'label' => 'Empresa',
                ],
                'address' => [
                    'type' => 'text',
                    'label' => 'Dirección',
                ],
                'message' => [
                    'type' => 'textarea',
                    'label' => 'Mensaje',
                ],
            ]));
        }
        return [
            'status'  => 'success',
            'message' => 'Mensaje enviado correctamente.',
            'type'    => request()->type
        ];
    }
    public function index($type) {
        $inputs = [];
        if ($type == 'custom-component') {
            $className = "\\App\\Dashboard\\Components\\" . request()->component;          
            $component = new $className;
            $inputs = $component->inputs();
        }
        $data = ContactRequest::where('type', $type)->orderBy('id', 'DESC')->paginate(20);
        return view('Dashboard::admin.contact.index', [
            'data'           => $data,
            'type'           => $type,
            'inputs'         => $inputs,
            '__admin_active' => 'admin.contact-'.$type
        ]);
    }
    public function show($type, $uuid) {
        $message = ContactRequest::where('type', $type)->where('uuid', $uuid)->first();
        $inputs = [];
        if ($type == 'custom-component') {
            $className = "\\App\\Dashboard\\Components\\" . $message->component;          
            $component = new $className;
            $inputs = $component->inputs();
        }
        return view('Dashboard::admin.contact.show', [
            'message'        => $message,
            'inputs'         => $inputs,
            '__admin_active' => 'admin.contact-'.$type
        ]);
    }
}
