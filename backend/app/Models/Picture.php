<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
class Picture extends Model
{
    public $timestamps = false;

    /**
     * The attributes that aren´t max assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the event that has pictures
     */
    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }
}
