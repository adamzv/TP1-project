<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 *
 * @author lacal
 */
class State extends Model
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
     * Get the cities for the State
     */
    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }
}
