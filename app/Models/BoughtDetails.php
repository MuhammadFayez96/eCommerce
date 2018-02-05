<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BoughtDetails
 * @package App\Models
 */
class BoughtDetails extends Model
{
    //
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "bought_details";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = ['amount', 'cost', 'product_type', 'product_id', 'product_option_value_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bought()
    {
        return $this->belongsTo('App\Models\Bought', 'bought_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productOptionValue()
    {
        return $this->belongsTo('App\Models\ProductOptionValues', 'product_option_value_id');
    }


}
