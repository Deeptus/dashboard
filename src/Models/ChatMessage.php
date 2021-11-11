<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class ChatMessage extends Model
{
    use SoftDeletes;

    protected $table = 'chat_message';
	protected $fillable = [
		'type',
        'content',
        'user_id',
        'chat_id',
    ];
    protected $appends  = [
        'created_at_ago',
        'created_at_format',
        'by',
        'me',
    ];
    public function user() {
        return $this->belongsTo(\AporteWeb\Dashboard\Models\User::class, 'user_id');
    }
    public function getByAttribute() {
        return $this->user->name;
    }
    public function getMeAttribute() {
        return $this->user->id == auth()->user()->id;
    }
    public function getCreatedAtAgoAttribute() {
        return $this->created_at->ago();
    }
    public function getCreatedAtFormatAttribute() {
        return $this->created_at->format('d\/m\/Y h:ia');
    }
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn('chat_message', 'uuid')) {
                $model->uuid = __uuid();
            }    
        });
    }
}
