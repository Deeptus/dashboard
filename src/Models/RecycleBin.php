<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use AporteWeb\Dashboard\Models\User;

class RecycleBin extends Model {

    protected $table = 'recycle_bin';
	protected $fillable = [
		'id',
		'table',
		'data',
        'reason',
		'user_id',
		'deleted_by'
    ];
    public function user() {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn('recycle_bin', 'uuid')) {
                $model->uuid = __uuid();
            }    
        });
    }
}