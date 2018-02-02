<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    //
    use SoftDeletes;
    protected $table = "cities";
    protected $dates = ['deleted_at'];

    public function cityTrans(){
        return $this->hasMany('App\Models\CityTranslation','city_id','id');
    }

    public function translate ($lange_id = null)
    {
        $local_lange_id = Language::where('lang_code', app()->getLocale())->first()->id;

        return $this->cityTrans()->where('lang_id', $lange_id ? $lange_id : $local_lange_id)->first();
    }

}
