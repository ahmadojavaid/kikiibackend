<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Conversation extends Model
{
	protected $fillable = ['participant_1_id', 'participant_2_id', 'deleted_by_user_id'];

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function participant_1()
    {
        return $this->belongsTo('App\User', 'participant_1_id', 'id');
    }

    public function participant_2()
    {
        return $this->belongsTo('App\User', 'participant_2_id', 'id');
    }

    public function deleteMedia()
    {
        File::deleteDirectory(
            public_path('storage/media/conversations/'. $this->id)
        );

        Media::where('conversation_id', $this->id)->delete();
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }
}
