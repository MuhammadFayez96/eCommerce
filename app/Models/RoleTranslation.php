<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleTranslation extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "role_translation";

    public function role() {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }
    public function language() {
        return $this->belongsTo('App\Models\Languages', 'lang_id');
    }

}
