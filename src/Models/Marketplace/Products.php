<?php

namespace AporteWeb\Dashboard\Models\Marketplace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Products extends Model {
    use SoftDeletes;

    protected $table = 'marketplace_products';
    protected $fillable = [
        'id',
        'uuid',
        'name',
        'slug',
        'layout_slug',
        'category_id',
    ];
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn($model->table, 'uuid')) {
                $model->uuid = __uuid();
            }
        });
    }
}