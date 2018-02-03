<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountryTranslation extends Model
{

    use SoftDeletes;

    protected $table = "countries_translation";
    protected $dates = ['deleted_at'];
    protected $fillable = ['country', 'lang_id'];

    public function country() {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public function language() {
        return $this->belongsTo('App\Models\Languages', 'lang_id');
    }


}
