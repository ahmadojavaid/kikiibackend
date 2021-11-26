<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntroImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'path'];

    public function getPathAttribute($value)
    {
    	return url('public/storage/media/intro_images/'. $value);
    }
}
