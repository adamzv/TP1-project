<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CreateRepeatsTable
 *
 * @author klukak
 */
class Attendance extends Model
{
    public $timestamps = false;

    /**
     * The attributes that aren´t max assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the event that has attendance
     */
    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }


}
