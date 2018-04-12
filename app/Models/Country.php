<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Country
 * @package App\Models
 */
class Country extends Model
{
    //
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "countries";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function countyTrans()
    {
        return $this->hasMany('App\Models\CountryTranslation', 'country_id', 'id');
    }


    public function city()
    {
        return $this->hasMany('App\Models\City', 'country_id', 'id');
    }
    /**
     * @param null $lang_code
     * @return Model|null|object|static
     */
    public function translate($lang_code = null)
    {
        if (!$lang_code) {

            $lang_id = Language::where('lang_code', app()->getLocale())->first()->id;
        } else {

            $lang_id = Language::where('lang_code', $lang_code)->first()->id;
        }

        return $this->countyTrans()->where('lang_id', $lang_id)->first();
    }

}
