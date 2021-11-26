<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $hidden = ['pivot', 'created_at', 'updated_at'];
	protected $fillable = ['name', 'description', 'datetime', 'cover_pic', 'user_id'];

	public function setCoverPicAttribute($file)
    {
        if ($file) {
            $name = $file->getClientOriginalName();
            $file->storeAs('public/media/events', $name);
            $this->attributes['cover_pic'] = $name;
        }
    }

    public function getCoverPicAttribute($value)
    {
        return $value ? url('public/storage/media/events/'. $value) : null;
    }

    public function attendants()
    {
        return $this->belongsToMany('App\User', 'event_user');
    }

    public function creator()
    {
    	return $this->belongsTo('App\User');
    }

      public function user()
    {
        return $this->belongsTo('App\User');
    }
}
