<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bought
 * @package App\Models
 */
class Bought extends Model
{
    //
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = "boughts";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boughtDetails()
    {
        return $this->hasMany('App\Models\BoughtDetails', 'bought_id', 'id');
    }
}
