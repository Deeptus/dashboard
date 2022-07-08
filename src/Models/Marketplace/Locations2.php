<?php

namespace AporteWeb\Dashboard\Models\Marketplace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use AporteWeb\Dashboard\Models\CrudBase;

class Locations2 extends Model {
    use SoftDeletes;
    use \AporteWeb\Dashboard\Traits\HasTranslations;
    use CrudBase;

    protected $table = 'marketplace_locations_2';
	protected $fillable = [
		'id',
        'uuid',
        'name',
        'lat',
        'lng',
        'location_1_id'
    ];
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn($model->table, 'uuid')) {
                $model->uuid = __uuid();
            }
        });
    }
    public function products() {
        return $this->hasMany(Products::class, 'category_id');
    }
}