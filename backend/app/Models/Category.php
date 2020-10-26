<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * @author lacal
 */
class Category extends Model
{
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the events that belong to the category
     */
    public function events()
    {
        return $this->belongsToMany('App\Models\Event');
    }
}
