<?php

namespace AporteWeb\Dashboard\Models\Marketplace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use AporteWeb\Dashboard\Models\CrudBase;

class TypeTaxpayer extends Model {
    use SoftDeletes;
    use \AporteWeb\Dashboard\Traits\HasTranslations;
    use CrudBase;

    protected $table = 'marketplace_type_taxpayer';
	protected $fillable = [
		'id',
        'uuid',
        'name',
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