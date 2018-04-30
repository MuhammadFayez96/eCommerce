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

    protected $fillable = ['role', 'display_name_en', 'display_name_ar', 'notes'];

    public function user()
    {
        return $this->hasMany('App\Models\User', 'role_id', 'id');
    }

}
