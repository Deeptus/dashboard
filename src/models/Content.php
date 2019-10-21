<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Content extends Model
{
    use HasTranslations, SoftDeletes;

    protected $table = 'contents';
	protected $fillable = [
		'lang',
        'order',
        'date',
		'url',
		'title',
		'subtitle',
		'text',
		'description',
		'image',
		'section',
		'block',
        'tags',
	];
	protected $casts = [
		'lang'    => 'array',
        'gallery' => 'array',
		'tags'    => 'array',
	];
    public $translatable = [
        'order',
		'url',
		'title',
		'subtitle',
		'text',
		'description',
		'image',
	];
    public function meta() {
        return $this->hasMany('App\ContentMeta', 'content_id');
    }
    public function updateMeta($request)
    {
        //dd($metaRequest);
        if (is_array($request->input('meta')) && $request->file('meta')) {
            $metaRequest = array_merge_recursive($request->input('meta'), $request->file('meta'));
        } else {
            $metaRequest = $request->meta;
        }
        $meta = [];
        if ($metaRequest and is_array($metaRequest)) {
            foreach ($metaRequest as $key => $value) {
                if (is_array($value)) {
                    $items = [];
                    foreach ($value as $item) {
                        if (!is_string($item) && $item->isFile()) {
                            $items[] = $item->store('public/files');
                        }
                        if (is_string($item)) {
                            $items[] = $item;
                        }
                    }
                    $value = implode(':;:', $items);
                }

                if ($value != null && !is_string($value) && $value->isFile()) {
                    $value = $value->store('public/files');
                }

                $meta[] = [
                    'meta_key'   => $key,
                    'meta_value' => $value,
                ];
            }
        }

        $this->meta()->delete();
        $this->meta()->createMany($meta);
    }
}
