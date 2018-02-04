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

    /**
     * @param null $lange_id
     * @return Model|null|object|static
     */
    public function translate($lang_id = null)
    {
        $local_lang_id = Language::where('lang_code', app()->getLocale())->first()->id;

        return $this->roleTrans()->where('lang_id', $lang_id ? $lang_id : $local_lang_id)->first();
    }

}
