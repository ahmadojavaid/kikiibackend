<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['path', 'link'];

    public function getPathAttribute($value)
    {
    	return url('public/storage/media/ad_images/'. $value);
    }
}
