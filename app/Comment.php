<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use App\Media;
use Carbon\Carbon;

class Comment extends Model
{
    protected $fillable = ['body'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans(null, false, true);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function replies(){
    	return $this->hasMany('App\Comment', 'comment_id', 'id');
    }

      public function media()
    {
       return $this->hasMany('App\Media');
    }

     public function insertMedia($media)
    {
        $files = [];
        foreach ($media as $file) {

            $name = $file->getClientOriginalName();
            $path = 'public/media/comments/'. $this->id . '/';

//            dd($path);

            $index = 1;
            do {
                $filename = $index .'-'. $name;
                $index++;
            } while(File::exists(storage_path('app/'. $path . $filename)));

            $file->storeAs($path, $filename);

            $files[] = [
                'path' => $filename,
                'comment_id' => $this->id,
                'user_id' => $this->user_id
            ];
        }

        Media::insert($files);
    }

      public function deleteMedia()
    {
        File::deleteDirectory(
            public_path('storage/media/'. $this->user_id . '/comments/'. $this->id . '/')
        );

        Media::where('comment_id', $this->id)->delete();
    }

    
}
