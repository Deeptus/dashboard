<?php

namespace AporteWeb\Dashboard\Models\Marketplace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use AporteWeb\Dashboard\Models\CrudBase;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Clients extends Authenticatable {

    use SoftDeletes;
    use \AporteWeb\Dashboard\Traits\HasTranslations;
    use CrudBase;
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'marketplace_clients';
	protected $fillable = [
		'id',
        'uuid',
        'name',
        'slug',
        'parent_id'
    ];
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn($model->table, 'uuid')) {
                $model->uuid = __uuid();
            }
        });
    }
    public function profiles() {
        return $this->hasMany(ClientProfiles::class, 'client_id');
    }
    public function default_profile() {
        return $this->hasOne(ClientProfiles::class, 'client_id')->orderBy('id', 'desc');
    }
    public function type_taxpayer() {
        return $this->belongsTo(TypeTaxpayer::class, 'type_taxpayer_id');
    }
}