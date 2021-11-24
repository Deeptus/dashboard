<?php

namespace AporteWeb\Dashboard\Models\Marketplace;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class PresentationPrices extends Model {
    protected $table = 'marketplace_presentation_prices';
    protected $fillable = [
        'id',
        'presentation_id',
        'price_list_id',
        'price'
    ];
    public static function boot() {
        parent::boot();
    }

    public function priceList() {
        return $this->belongsTo(PriceList::class, 'price_list_id', 'id');
    }

    public function presentation() {
        return $this->belongsTo(Presentation::class, 'presentation_id', 'id');
    }
}