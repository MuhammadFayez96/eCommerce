<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App\Models
 */
class Product extends Model
{
    //
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = "products";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productOptionValue()
    {
        return $this->hasMany('App\Models\ProductOptionValues', 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boughtDetails()
    {
        return $this->hasMany('App\Models\BoughtDetails', 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productTrans()
    {
        return $this->hasMany('App\Models\ProductTranslation', 'product_id', 'id');
    }

    /**
     * @param null $lange_id
     * @return Model|null|object|static
     */
    public function translate($lange_id = null)
    {
        $local_lange_id = Language::where('lang_code', app()->getLocale())->first()->id;

        return $this->productTrans()->where('lang_id', $lange_id ? $lange_id : $local_lange_id)->first();
    }


}
