<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionTranslation extends Model
{
    //
    use SoftDeletes;
    protected $table = "option_translation";
    protected $dates = ['deleted_at'];

    public function option() {
        return $this->belongsTo('App\Models\Option', 'option_id');
    }

    public function language() {
        return $this->belongsTo('App\Models\Languages', 'lang_id');
    }

}
