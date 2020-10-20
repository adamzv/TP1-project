<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Place
 *
 * @author lacal
 */
class Place extends Model
{
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the city that owns the place
     */
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
}
