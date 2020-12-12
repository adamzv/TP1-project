<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Place
 *
 * @author lacal
 */
class Place extends Model
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
     * Get the city that owns the place
     */
    public function city()
    {
        return $this->belongsTo('App\Models\City', 'id_city');
    }
}
