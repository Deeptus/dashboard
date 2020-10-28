<?php
namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentMeta extends Model {

    protected $table = 'content_meta';
    protected $fillable = [
        'meta_key',
        'meta_value',
        'content_id',
    ];
}
