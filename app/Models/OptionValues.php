<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionValues extends Model
{
    //
    use SoftDeletes;
    protected $table = "option_values";
    protected $dates = ['deleted_at'];

    public function optionValuesTrans(){
        return $this->hasMany('App\Models\OptionValuesTranslation','option_value_id','id');
    }

    public function productOptionValuesDetails(){
        return $this->hasMany('App\Models\ProductOptionValuesDetails','option_value_id','id');
    }

    public function option() {
        return $this->belongsTo('App\Models\Option', 'option_id');
    }

    public function translate ($lange_id = null)
    {
        $local_lange_id = Language::where('lang_code', app()->getLocale())->first()->id;

        return $this->optionValuesTrans()->where('lang_id', $lange_id ? $lange_id : $local_lange_id)->first();
    }

}
