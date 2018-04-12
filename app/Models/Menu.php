<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Menu
 * @package App\Models
 */
class Menu extends Model
{
    //
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = "menus";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuTrans()
    {
        return $this->hasMany('App\Models\MenuTranslation', 'menu_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'menu_id', 'id');
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

        return $this->menuTrans()->where('lang_id', $lang_id)->first();
    }

}
