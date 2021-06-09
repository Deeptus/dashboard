<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Chat extends Model
{
    use SoftDeletes;

    protected $table = 'chat';
	protected $fillable = [
		'ref',
        'state',
        'description',
    ];
    public function user() {
        return $this->hasMany(\AporteWeb\Dashboard\Models\User::class, 'content_id');
    }
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn('chat', 'uuid')) {
                $model->uuid = __uuid();
            }    
        });
    }
}
