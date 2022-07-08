<?php

namespace AporteWeb\Dashboard\Models\Marketplace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use AporteWeb\Dashboard\Models\CrudBase;

class ClientProfiles extends Model {
    use SoftDeletes;
    use \AporteWeb\Dashboard\Traits\HasTranslations;
    use CrudBase;

    protected $table = 'marketplace_client_profiles';
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
    public function client() {
        return $this->belongsTo(Clients::class, 'client_id');
    }
}