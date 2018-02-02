<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryTranslation extends Model
{
    //
    use SoftDeletes;

    protected $table = "category_translation";
    protected $dates = ['deleted_at'];

    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function language() {
        return $this->belongsTo('App\Models\Languages', 'lang_id');
    }


}
