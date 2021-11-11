<?php print '<?php' ?>

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<?php if($this->table->softDeletes): ?>
use Illuminate\Database\Eloquent\SoftDeletes;
<?php endif ?>
use Illuminate\Support\Str;
use AporteWeb\Dashboard\Models\CrudBase;
<?php if($this->table->is_authenticatable): ?>
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Junges\ACL\Concerns\UsersTrait;
<?php endif ?>

class <?php print $className ?> extends <?php print $this->table->is_authenticatable ? 'Authenticatable' : 'Model' ?> {
<?php if($this->table->is_authenticatable): ?>
    use HasFactory, Notifiable, UsersTrait;
<?php endif ?>
<?php if($this->table->softDeletes): ?>
    use SoftDeletes;
<?php endif ?>
<?php if($this->table->translation_method == "spatie-laravel-translatable"): ?>
    use \AporteWeb\Dashboard\Traits\HasTranslations;
<?php endif ?>
    use CrudBase;

	protected $table = '<?php print $this->table->tablename ?>';

    protected $fillable = [
        'id',
<?php foreach ($this->inputs as $key => $input): ?>
<?php
if ($input->type == 'card-header') {
    continue;
}
?>
        '<?php print $input->columnname ?>',
<?php endforeach ?>
	];
	protected $casts = [
	];
<?php if($this->table->is_authenticatable): ?>
    protected $hidden = [
        'password',
        'remember_token',
    ];
<?php endif ?>

    public static function boot() {
        parent::boot();
<?php if($this->table->uuid): ?>
        self::creating(function ($model) {
            $model->uuid = __uuid();
        });
<?php endif ?>
    }
}