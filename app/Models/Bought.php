<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bought extends Model
{
    //
    use SoftDeletes;
    protected $table = "bought";
    protected $dates = ['deleted_at'];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function boughtDetails(){
        return $this->hasMany('App\Models\BoughtDetails','bought_id','id');
    }
}
