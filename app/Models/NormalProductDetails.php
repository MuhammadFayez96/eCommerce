<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NormalProductDetails extends Model
{
    //
    use SoftDeletes;
    protected $table = "normal_product_details";
    protected $dates = ['deleted_at'];

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }


}
