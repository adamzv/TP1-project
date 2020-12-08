<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Class Event
 *
 * @author lacal
 */
class Event extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $appends = ['pdf', 'titleImg', 'images'];

    public function getPdfAttribute()
    {
        return $this->getPdf($this->id);
    }

    public function gettitleImgAttribute()
    {
        return $this->getTitleImg($this->id);
    }

    public function getImagesAttribute()
    {
        return $this->getImages($this->id);
    }

    /**
     * Gets pdf paths that belong to the event
     *
     * @param $id
     * @return array
     */
    public function getPdf($id)
    {
        // create empty array for pdfs paths
        $pdfPathArr = [];

        // get file names in event directory to array
        $filesName = Storage::disk('azure')->allFiles('pdf/' . $id);

        $i = 0;

        // run through filenames array
        foreach ($filesName as $fileName) {
            $i++;

            // write pdf path to array
            array_push($pdfPathArr, $fileName);
        }

        return $pdfPathArr;
    }

    /**
     * Gets title images paths that belong to the event
     *
     * @param $id
     * @return array
     */
    public function getTitleImg($id)
    {
        // create empty array for title image paths
        $titleImgPathArr = [];

        // get file names in event directory to array
        $filesName = Storage::disk('azure')->allFiles('titleImg/' . $id);

        $i = 0;

        // run through filenames array
        foreach ($filesName as $fileName) {
            $i++;

            // write title image path to array
            array_push($titleImgPathArr, $fileName);
        }

        return $titleImgPathArr;
    }

    /**
     * Gets images paths that belong to event
     *
     * @param $id
     * @return array
     */
    public function getImages($id)
    {
        // create empty array for images paths
        $imagePathArr = [];

        // get file names in event directory to array
        $filesName = Storage::disk('azure')->allFiles('images/' . $id);

        $i = 0;

        // run through filenames array
        foreach ($filesName as $fileName) {
            $i++;

            // write image path to array
            array_push($imagePathArr, $fileName);
        }

        return $imagePathArr;
    }

    /**
     * Get the user that owns the event
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    /**
     * Get the place that belongs to the event
     */
    public function place()
    {
        return $this->belongsTo('App\Models\Place', 'id_place');
    }

    /**
     * Get the faculty that belongs to the event
     */
    public function faculty()
    {
        return $this->belongsTo('App\Models\Faculty', 'id_faculty');
    }

    /**
     * Get the department that belongs to the event
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'id_department');
    }

    /**
     * Get the categories that belong to the event
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');

    }

    /**
     * Get the attendance of users that belongs to the event
     */
    public function attendance()
    {
        return $this->belongsToMany('App\Models\User');

    }


    public function emails()
    {
        return $this->belongsToMany('App\Models\Email', 'event_user');
    }
}
