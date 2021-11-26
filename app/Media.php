<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['path','message_id','comment_id', 'user_id', 'post_id'];

    public function getPathAttribute($value)
    {
    	$item = 'profile_pics';
    	$id = $this->user_id;

		if ($this->post_id) {
    		$item = 'posts';
    		$id = $this->post_id;

    	} elseif ($this->message_id) {
            $item = 'messages';
            $id = $this->message_id;

        } elseif ($this->comment_id) {
            $item = 'comments';
            $id = $this->comment_id;
        }

    	return url('public/storage/media/'. $item . '/'. $id . '/' . $value);
    }


}
