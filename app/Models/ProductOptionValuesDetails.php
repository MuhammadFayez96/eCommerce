<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOptionValuesDetails extends Model
{
    //
    use SoftDeletes;
    protected $table = "product_option_values_details";
    protected $dates = ['deleted_at'];

    public function productOptionValue() {
        return $this->belongsTo('App\Models\ProductOptionValues', 'product_option_value_id');
    }

    public function OptionValue() {
        return $this->belongsTo('App\Models\OptionValues', 'option_value_id');
    }


}
