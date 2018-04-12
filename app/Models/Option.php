<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Option
 * @package App\Models
 */
class Option extends Model
{
    //
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = "options";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function optionTrans()
    {
        return $this->hasMany('App\Models\OptionTranslation', 'option_id', 'id');
    }

    public function optionValues()
    {
        return $this->hasMany('App\Models\OptionValues', 'option_id', 'id');
    }

    public function optionValuesTranslated($lang_code = null)
    {

      if (!$lang_code) {

        $lang_id = Language::where('lang_code', app()->getLocale())->first()->id;

      } else {

        $lang_id = Language::where('lang_code', $lang_code)->first()->id;

      }

        return $this->optionValues()->where('lang_id', $lang_id)->get();
    }

    public function optionValues_details()
    {
        return $this->optionValues()->getResults();
    }

    /**
     * @param null $lang_code
     * @return Model|null|object|static
     */
    public function translate($lang_code = null)
    {
      if (!$lang_code) {

        $lang_id = Language::where('lang_code', app()->getLocale())->first()->id;

      }else {

        $lang_id = Language::where('lang_code', $lang_code)->first()->id;

      }

        return $this->optionTrans()->where('lang_id', $lang_id)->first();
    }

}
