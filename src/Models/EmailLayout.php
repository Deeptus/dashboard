<?php
namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailLayout extends Model
{
    use SoftDeletes;
    protected $table = 'email_layouts';

    protected $fillable = [
        'key',
        'description',
        'subject',
    	'body',
    ];
    public static function boot() {
        parent::boot();
    }
}