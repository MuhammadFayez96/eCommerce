<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OptionValuesTranslation
 * @package App\Models
 */
class OptionValuesTranslation extends Model
{
    //
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = "option_values_translation";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = ['value', 'lang_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function optionValue()
    {
        return $this->belongsTo('App\Models\OptionValues', 'option_value_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo('App\Models\Languages', 'lang_id');
    }

}
