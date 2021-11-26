<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeDislike extends Model
{
	protected $table = 'likes_dislikes';
    protected $fillable = ['liker_id', 'disliker_id', 'user_id', 'chat'];
}
