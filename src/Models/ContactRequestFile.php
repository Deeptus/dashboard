<?php
namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class ContactRequestFile extends Model {
    use SoftDeletes;
    
    protected $table = 'contact_request_file';
    protected $fillable = [
        'uuid',
        'path',
        'original_name',
        'observation',
        'contact_request_id',
    ];
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn('contact_request_file', 'uuid')) {
                $model->uuid = __uuid();
            }    
        });
    }
}