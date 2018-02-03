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


    /**
     * @param null $lang_id
     * @return Model|null|object|static
     */
    public function translate($lang_id = null)
    {
        $local_lang_id = Language::where('lang_code', app()->getLocale())->first()->id;

        return $this->countyTrans()->where('lang_id', $lang_id ? $lang_id : $local_lang_id)->first();
    }


}
