<?php
namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class ConfigVar extends Model {
    protected $table = 'config_vars';
    protected $fillable = [
        'config_key',
        'config_value',
    ];
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn('config_vars', 'uuid')) {
                $model->uuid = __uuid();
            }    
        });
    }
}