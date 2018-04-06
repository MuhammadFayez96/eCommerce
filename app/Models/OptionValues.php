<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OptionValues
 * @package App\Models
 */
class OptionValues extends Model
{
    //
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = "option_values";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function optionValuesTrans()
    {
        return $this->hasMany('App\Models\OptionValuesTranslation', 'option_value_id', 'id');
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productOptionValuesDetails()
    {
        return $this->hasMany('App\Models\ProductOptionValuesDetails', 'option_value_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option()
    {
        return $this->belongsTo('App\Models\Option', 'option_id');
    }

    /**
     * @param null $lang_id
     * @return Model|null|object|static
     */
    public function translate($lang_id = null)
    {
        $local_lang_id = Language::where('lang_code', app()->getLocale())->first()->id;


        return $this->optionValuesTrans()->where('lang_id', $lang_id ? $lang_id : $local_lang_id)->first();
    }

}
