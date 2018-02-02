<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //
    use SoftDeletes;

    protected $table = "categories";
    protected $dates = ['deleted_at'];

    public function categoryTrans(){
        return $this->hasMany('App\Models\CategoryTranslation','category_id','id');
    }

    public function menu() {
        return $this->belongsTo('App\Models\Menu', 'menu_id');
    }

    public function translate ($lange_id = null)
    {
        $local_lange_id = Language::where('lang_code', app()->getLocale())->first()->id;

        return $this->categoryTrans()->where('lang_id', $lange_id ? $lange_id : $local_lange_id)->first();
    }


}
