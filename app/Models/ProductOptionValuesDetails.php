<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductOptionValuesDetails
 * @package App\Models
 */
class ProductOptionValuesDetails extends Model
{
    //
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = "product_option_values_details";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productOptionValue()
    {
        return $this->belongsTo('App\Models\ProductOptionValues', 'product_option_value_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function OptionValue()
    {
        return $this->belongsTo('App\Models\OptionValues', 'option_value_id');
    }


}
