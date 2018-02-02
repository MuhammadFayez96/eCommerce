<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    //
    use SoftDeletes;
    protected $table = "roles";
    protected $dates = ['deleted_at'];

    public function roleTrans(){
        return $this->hasMany('App\Models\RoleTranslation','role_id','id');
    }

    public function translate ($lange_id = null)
    {
        $local_lange_id = Language::where('lang_code', app()->getLocale())->first()->id;

        return $this->roleTrans()->where('lang_id', $lange_id ? $lange_id : $local_lange_id)->first();
    }

}
