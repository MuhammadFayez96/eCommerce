<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MenuTranslation
 * @package App\Models
 */
class MenuTranslation extends Model
{
    //
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = "menus_translation";
    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = ['description', 'notes', 'lang_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo('App\Models\Menu', 'menu_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo('App\Models\Languages', 'lang_id');
    }


}
