<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 * @package App\Models
 */
class Role extends Model
{
    //
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = "roles";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roleTrans()
    {
        return $this->hasMany('App\Models\RoleTranslation', 'role_id', 'id');
    }

    public function user()
    {
        return $this->hasMany('App\Models\User', 'role_id', 'id');
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

        return $this->roleTrans()->where('lang_id', $lang_id)->first();
    }

}
