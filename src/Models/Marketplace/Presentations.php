<?php

namespace AporteWeb\Dashboard\Models\Marketplace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Presentations extends Model {
    use SoftDeletes;

    protected $table = 'marketplace_presentations';
    protected $fillable = [
        'id',
        'name',
        'slug',
        'product_id'
    ];
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn($model->table, 'uuid')) {
                $model->uuid = __uuid();
            }
        });
    }
    // marketplace_presentation_prices
    public function prices() {
        return $this->hasMany(PresentationPrices::class, 'presentation_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}