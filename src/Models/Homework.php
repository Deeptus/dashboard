<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;
use AporteWeb\Dashboard\Models\User;
use Carbon\Carbon;

class Homework extends Model
{
    use SoftDeletes;

    protected $table = 'homework';
	protected $fillable = [
		'title',
		'details',
		'individual',
		'start_at',
		'finish_at',
		'finished_at',
		'user_id',
    ];
    protected $dates = [
        'start_at',
        'finish_at',
    ];    
    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn('homework', 'uuid')) {
                $model->uuid = __uuid();
            }    
        });
    }
    public function getUserNameAttribute() {
        return $this->user->name;
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function users() {
        return $this->belongsToMany(User::class, 'homework_user', 'homework_id', 'user_id')->withPivot('read_at','finished_at');
    }
    public function getUsersStateAttribute() {
        return $this->users()->get(['username', 'name', 'email']);
    }
    public function getCreatedAtAgoAttribute() {
        return $this->created_at->ago();
    }
    public function getStartAtFormatedAttribute()
    {
        Carbon::setUTF8(true);
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');
        // dd($this->created_at->formatLocalized('%d de %B del %Y a las %I:%M:%S %p'));
        return $this->start_at->isoFormat('D [de] MMMM [del] YYYY [a las] h:mm A');
    }
}