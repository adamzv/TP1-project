<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 *
 * @author lacal
 */
class Department extends Model
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
     * Get the faculty that owns the department
     */
    public function faculty()
    {
        return $this->belongsTo('App\Models\Faculty');
    }
}
