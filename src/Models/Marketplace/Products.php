<?php

namespace AporteWeb\Dashboard\Models\Marketplace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use AporteWeb\Dashboard\Models\CrudBase;

class Products extends Model {
    use SoftDeletes;
    use \AporteWeb\Dashboard\Traits\HasTranslations;
    use CrudBase;

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

    public function presentations() {
        return $this->hasMany(Presentations::class, 'product_id', 'id');
    }

    public function category() {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }
    public function categories() {
        return $this->belongsToMany(Categories::class, 'marketplace_product_categories', 'product_id', 'category_id');
        // return $this->belongsToMany(Multimedia::class, 'gallery_multimedia', 'gallery_id', 'multimedia_id')->withTimestamps()->withPivot('order')->orderBy('gallery_multimedia.order');
    }
}