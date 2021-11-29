<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use AporteWeb\Dashboard\Models\Translation;

class TranslationManagerController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    public function data() {
        $translations = Translation::withTrashed()->get();
        $langs = LaravelLocalization::getSupportedLocales();
        $langs_keys = array_keys($langs);
        return [
            'translations' => $translations,
            'langs' => $langs,
            'langs_keys' => $langs_keys,
            'current_lang' => App::getLocale()
        ];
    }
    public function store() {
        $translations = json_decode(request()->translations, true);
        foreach ($translations as $key => $translation) {
            if (array_key_exists('id', $translation)) {
                $t = Translation::withTrashed()->find($translation['id']);
            } else {
                $t = new Translation;
            }
            $t->key = $translation['key'];
            $t->setTranslations('translation', $translation['translation']);
            if (array_key_exists('deleted_at', $translation)) {
                $t->deleted_at = $translation['deleted_at'];
            }
            $t->save();
        }
        return response()->json(['success' => true]);
    }
    public function delete() {
        
    }
}
