<?php

namespace AporteWeb\Dashboard\Models\Marketplace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use AporteWeb\Dashboard\Models\CrudBase;

class PriceList extends Model {
    use SoftDeletes;
    use \AporteWeb\Dashboard\Traits\HasTranslations;
    use CrudBase;

    protected $table = 'marketplace_price_list';
    protected $fillable = [
        'id',
        'uuid',
        'name',
        'slug',
        'parent_id',
    ];
    public static function boot() {
        parent::boot();
    }
}