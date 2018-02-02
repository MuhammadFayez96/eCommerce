<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    //
    use SoftDeletes;
    protected $table = "options";
    protected $dates = ['deleted_at'];

    public function optionTrans(){
        return $this->hasMany('App\Models\OptionTranslation','option_id','id');
    }

    public function translate ($lange_id = null)
    {
        $local_lange_id = Language::where('lang_code', app()->getLocale())->first()->id;

        return $this->optionTrans()->where('lang_id', $lange_id ? $lange_id : $local_lange_id)->first();
    }


}
