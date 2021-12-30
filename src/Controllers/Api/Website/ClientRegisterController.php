<?php
namespace AporteWeb\Dashboard\Controllers\Api\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Auth\RegistersUsers;

use AporteWeb\Dashboard\Rules\CUIT;

use AporteWeb\Dashboard\Models\Marketplace\Locations1;
use AporteWeb\Dashboard\Models\Marketplace\Locations2;
use AporteWeb\Dashboard\Models\Marketplace\TypeTaxpayer;
use AporteWeb\Dashboard\Models\Marketplace\Clients;
use AporteWeb\Dashboard\Models\Marketplace\ClientProfiles;

use \App\Models\CompanyData;

use AporteWeb\Dashboard\Mail\NewRegisteredClient;

class ClientRegisterController extends Controller {

    public function __construct() {
        
    }

    public function data() {
        return [
            'locations_1'  => Locations1::orderBy('name')->get(['id', 'name']),
            'locations_2' => Locations2::orderBy('name')->get(['id', 'name', 'location_1_id']),
            'type_taxpayer'   => TypeTaxpayer::get(['id', 'name']),
        ];
    }
    public function register() {
        $inputNames = [
            'full_name'        => '<strong>Persona de Contacto / Nombre y Apellido</strong>',
            'dni'              => '<strong>DNI</strong>',
            'phone'            => '<strong>Teléfono</strong>',
            'address'          => '<strong>Dirección de Domicilio</strong>',
            'business_name'    => '<strong>Razón Social / Empresa</strong>',
            'type_taxpayer_id' => '<strong>Tipo de Contribuyente</strong>',
            'cuit'             => '<strong>CUIT</strong>',
            'location_1_id'    => '<strong>Provincia</strong>',
            'location_2_id'    => '<strong>Localidad</strong>',
            'zip'              => '<strong>Código Postal</strong>',
            'email'            => '<strong>Correo Electronico</strong>',
            'password'         => '<strong>Contraseña</strong>',
        ];
        $validator = Validator::make(request()->all(), [
            'full_name'        => ['required', 'string', 'max:190'],
            'dni'              => [
                Rule::requiredIf(request()->has('dni')),
                'integer'
            ],
            'phone'            => ['required', 'string', 'max:190'],
            'address'          => ['required', 'string', 'max:190'],
            'business_name'    => ['required', 'string', 'max:190'],
            'type_taxpayer_id' => ['required', 'integer'],
            'cuit'             => [
                'required',
                'string',
                'max:13',
                'unique:marketplace_client_profiles',
                new CUIT
            ],
            'location_1_id'  => ['required', 'integer'],
            'location_2_id'  => ['required', 'integer'],
            'zip' => ['required', 'string', 'max:190'],
            'email'         => ['required', 'string', 'email', 'max:190', 'unique:marketplace_clients'],
            //'username'      => ['required', 'string', 'max:190', 'unique:marketplace_clients'],
            'password'      => ['required', 'string', 'min:6', 'confirmed'],
        ], [], $inputNames);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()->all(),
            ]);
        }
        $config = CompanyData::first();
        $client = new Clients;
        $client->username         = Str::random(16);
        $client->full_name        = request()->full_name;
        $client->email            = request()->email;
        $client->password         = Hash::make(request()->password);
        $client->type_taxpayer_id = request()->type_taxpayer_id;
        $client->deleted_at       = \Carbon\Carbon::now();
        $client->save();

        $profile = new ClientProfiles;
        $profile->dni              = request()->dni;
        $profile->full_name        = request()->full_name;
        $profile->phone            = request()->phone;
        $profile->address          = request()->address;
        $profile->business_name    = request()->business_name;
        $profile->cuit             = request()->cuit;
        $profile->location_1_id    = request()->location_1_id;
        $profile->location_1_name  = Locations1::find(request()->location_1_id)->name;
        $profile->location_2_id    = request()->location_2_id;
        $profile->location_2_name  = Locations2::find(request()->location_2_id)->name;
        $profile->zip              = request()->zip;
        $profile->client_id        = $client->id;
        $profile->save();

        Mail::to($config->email_system)->send(new NewRegisteredClient($client));
        return response()->json([
            'status' => 'success',
            'message' => 'El usuario se ha registrado correctamente.',
        ]);
    }
}