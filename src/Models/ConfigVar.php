<?php
namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigVar extends Model {
    protected $table = 'config_vars';
    protected $fillable = [
        'config_key',
        'config_value',
    ];



}
