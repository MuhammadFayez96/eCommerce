<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 * @package App\Models
 */
class Category extends Model
{
    //
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "categories";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoryTrans()
    {
        return $this->hasMany('App\Models\CategoryTranslation', 'category_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo('App\Models\Menu', 'menu_id');
    }

    /**
     * @param null $lang_code
     * @return Model|null|object|static
     */
    public function translate($lang_code = null)
    {
        if (!$lang_code) {

            $lang_id = Language::where('lang_code', app()->getLocale())->first()->id;
        } else {

            $lang_id = Language::where('lang_code', $lang_code)->first()->id;
        }

        return $this->categoryTrans()->where('lang_id', $lang_id)->first();
    }

    /**
    * get main category
    */
    public function main()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    /**
    * get sub categories
    */
    public function subs()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    /**
    * check if main category
    */
    public function isMain()
    {
        return $this->parent_id == 0;
    }
}
