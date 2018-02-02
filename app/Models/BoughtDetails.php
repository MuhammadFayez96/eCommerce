<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoughtDetails extends Model
{
    //
    use SoftDeletes;

    protected $table = "bought_details";
    protected $dates = ['deleted_at'];

    public function bought() {
        return $this->belongsTo('App\Models\Bought', 'bought_id');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function productOptionValue() {
        return $this->belongsTo('App\Models\ProductOptionValues', 'product_option_value_id');
    }


}
