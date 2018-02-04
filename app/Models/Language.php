<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Language
 * @package App\Models
 */
class Language extends Model
{
    //
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = "languages";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

}
