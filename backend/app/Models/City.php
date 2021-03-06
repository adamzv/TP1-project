<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class City
 *
 * @author lacal
 */
class City extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the state that owns the city
     */
    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }

    /**
     * Get the places for the city
     */
    public function places()
    {
        return $this->hasMany('App\Models\Place');
    }
}
