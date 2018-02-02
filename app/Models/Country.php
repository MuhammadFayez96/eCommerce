<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    //
    use SoftDeletes;

    protected $table = "countries";
    protected $dates = ['deleted_at'];

    public function countyTrans(){
        return $this->hasMany('App\Models\CountryTranslation','country_id','id');
    }


    public function translate ($lange_id = null)
    {
        $local_lange_id = Language::where('lang_code', app()->getLocale())->first()->id;
        return $this->countyTrans()->where('lang_id', $lange_id ? $lange_id : $local_lange_id)->first();
    }


}
