<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KikiPost extends Model
{
    protected $table = "kiki_posts";
    protected $fillable = ['title', 'body'];

    public function likes()
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
