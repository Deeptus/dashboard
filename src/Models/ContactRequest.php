<?php
namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class ContactRequest extends Model {
    use SoftDeletes;

    protected $table = 'contact_request';
    protected $fillable = [
        'id',
        'uuid',
        'name',
        'company',
        'company_code',
        'phone',
        'postal_code',
        'address',
        'email',
        'message',
        'observation',
        'shipping_price',
        'subtotal',
        'discounts',
        'discount',
        'taxes',
        'tax',
        'total',
        'ref_id',
        'type',
        'read_at',
        'notified_at'
    ];
    protected $appends = [
        'created_at_formatted',
    ];
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn('contact_request', 'uuid')) {
                $model->uuid = __uuid();
            }    
        });
    }
    public function items() {
        return $this->hasMany(ContactRequestItems::class, 'contact_request_id', 'id');
    }
    public function files() {
        return $this->hasMany(ContactRequestFile::class, 'contact_request_id', 'id');
    }
    public function getCreatedAtFormattedAttribute() {
        return $this->created_at->format('d/m/Y h:i A');
    }
}