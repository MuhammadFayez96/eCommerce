<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTranslation extends Model
{
    //
    use SoftDeletes;
    protected $table = "product_translation";
    protected $dates = ['deleted_at'];

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function language() {
        return $this->belongsTo('App\Models\Languages', 'lang_id');
    }

}
