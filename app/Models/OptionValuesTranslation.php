<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionValuesTranslation extends Model
{
    //
    use SoftDeletes;
    protected $table = "option_values_translation";
    protected $dates = ['deleted_at'];


    public function optionValue() {
        return $this->belongsTo('App\Models\OptionValues', 'option_value_id');
    }

    public function language() {
        return $this->belongsTo('App\Models\Languages', 'lang_id');
    }

}
