<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Junges\ACL\Concerns\UsersTrait;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, UsersTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sucursal() {
        return $this->belongsTo('App\Models\Sucursal', 'sucursal_id');
    }
    public function getKey() {
        if ($this->uuid) {
            return $this->uuid;
        } else {
            return $this->id;
        }
    }
    public function homework() {
        return $this->belongsToMany(Homework::class, 'homework_user', 'user_id', 'homework_id')->withPivot('read_at','finished_at');
    }
}
