<?php

namespace AporteWeb\Dashboard\Models\Marketplace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use AporteWeb\Dashboard\Models\CrudBase;

class Categories extends Model {
    use SoftDeletes;
    use \AporteWeb\Dashboard\Traits\HasTranslations;
    use CrudBase;

    protected $table = 'marketplace_categories';
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
    // products with pivot table *pproducts*
    public function products() {
        return $this->belongsToMany(Products::class, 'marketplace_product_categories', 'category_id', 'product_id');
    }
    // direct products *dproducts*
    public function dproducts() {
        return $this->hasMany(Products::class, 'category_id');
    }
}