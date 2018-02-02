<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;
    protected $table = "products";
    protected $dates = ['deleted_at'];

    public function productOptionValue(){
        return $this->hasMany('App\Models\ProductOptionValues','product_id','id');
    }

    public function boughtDetails(){
        return $this->hasMany('App\Models\BoughtDetails','product_id','id');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function productTrans(){
        return $this->hasMany('App\Models\ProductTranslation','product_id','id');
    }

    public function translate ($lange_id = null)
    {
        $local_lange_id = Language::where('lang_code', app()->getLocale())->first()->id;

        return $this->productTrans()->where('lang_id', $lange_id ? $lange_id : $local_lange_id)->first();
    }


}
