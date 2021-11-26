<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Message extends Model
{
    protected $fillable = ['body', 'sender_id', 'receiver_id', 'conversation_id', 'read_at'];

    public function media()
    {
    	return $this->hasOne('App\Media');
    }

    public function conversation()
    {
        return $this->belongsTo('App\Conversation');
    }

    public function insertMedia($file)
    {
       $name = $file->getClientOriginalName();
        $file->storeAs(
            'public/media/conversations/'. $this->conversation_id . '/messages/'. $this->id, $name
        );

        Media::create([
            'path' => $name,
            'message_id' => $this->id,
            'conversation_id' => $this->conversation_id,
            'user_id' => $this->sender_id
        ]);
    }
    
    public function deleteMedia()
    {
        File::deleteDirectory(
        	public_path('storage/media/conversations/'. $this->conversation_id . '/messages/'. $this->id . '/')
        );

        Media::where('message_id', $this->id)->delete();
    }

    public function sender_id()
    {
        return $this->belongsTo('App\User', 'sender_id', 'id');
    }

    public function receiver_id()
    {
        return $this->belongsTo('App\User', 'receiver_id', 'id');
    }
}
