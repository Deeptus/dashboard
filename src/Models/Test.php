<?php
namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
	use SoftDeletes;
	protected $table = 'test';

	protected $fillable = [
		'text',
	];
	protected $casts = [
		'text' => 'array'
	];

}