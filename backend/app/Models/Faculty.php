<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Faculty
 *
 * @author lacal
 */
class Faculty extends Model
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
}
