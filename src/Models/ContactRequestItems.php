<?php
namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class ContactRequestItems extends Model {
    use SoftDeletes;
    
    protected $table = 'contact_request_items';
    protected $fillable = [
        'uuid',
        'ref_id',
        'name',
        'image_url',
        'description',
        'code',
        'presentation',
        'color_name',
        'size',
        'piece_weight',
        'base_price',
        'discounts',
        'discount',
        'taxes',
        'tax',
        'unit_price',
        'quantity',
        'contact_request_id',
    ];
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn('contact_request_items', 'uuid')) {
                $model->uuid = __uuid();
            }    
        });
    }
}