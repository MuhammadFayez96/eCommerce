<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductOptionValues
 * @package App\Models
 */
class ProductOptionValues extends Model
{
    //
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = "product_option_values";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productOptionValueDetails()
    {
        return $this->hasMany('App\Models\ProductOptionValuesDetails', 'product_option_value_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boughtDetails()
    {
        return $this->hasMany('App\Models\BoughtDetails', 'product_option_value_id', 'id');
    }


}
