<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CityTranslation extends Model
{
    //
    use SoftDeletes;
    protected $table = "cities_translation";
    protected $dates = ['deleted_at'];

    public function city() {
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function language() {
        return $this->belongsTo('App\Models\Languages', 'lang_id');
    }


}
