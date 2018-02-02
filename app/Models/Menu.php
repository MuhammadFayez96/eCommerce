<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    //
    use SoftDeletes;
    protected $table = "menu";
    protected $dates = ['deleted_at'];

    public function optionValuesTrans(){
        return $this->hasMany('App\Models\MenuTranslation','menu_id','id');
    }


    public function translate ($lange_id = null)
    {
        $local_lange_id = Language::where('lang_code', app()->getLocale())->first()->id;

        return $this->optionValuesTrans()->where('lang_id', $lange_id ? $lange_id : $local_lange_id)->first();
    }

}
