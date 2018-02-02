<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOptionValues extends Model
{
    //
    use SoftDeletes;
    protected $table = "product_option_values";
    protected $dates = ['deleted_at'];

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function productOptionValueDetails(){
        return $this->hasMany('App\Models\ProductOptionValuesDetails','product_option_value_id','id');
    }

    public function boughtDetails(){
        return $this->hasMany('App\Models\BoughtDetails','product_option_value_id','id');
    }


}
