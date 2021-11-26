<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use App\Media;

class Post extends Model
{
    protected $fillable = ['body'];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans(null, false, true);
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
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
            $path = 'public/media/posts/'. $this->id . '/';

            $index = 1;
            do {
                $filename = $index .'-'. $name;
                $index++;
            } while(File::exists(storage_path('app/'. $path . $filename)));

            $file->storeAs($path, $filename);

            $files[] = [
                'path' => $filename,
                'post_id' => $this->id,
                'user_id' => $this->user_id
            ];
        }

        Media::insert($files);
    }

    public function deleteMedia($ids = null)
    {
        $path = public_path('storage/media/'. $this->user_id . '/posts/'. $this->id . '/');

        $media = $ids
            ? Media::whereIn('id', explode(',', $ids))
            : Media::where('post_id', $this->id);

        if ($ids) {
            foreach ($media->get() as $file) {
                File::delete($path.$file->path);
            }
        } else {
            File::deleteDirectory($path);
        }

        $media->delete();
    }

    public function isAuthUserLikedPost(){
        $like = $this->likes()->where('user_id',  Auth::user()->id)->get();
        if ($like->isEmpty()){
            return false;
        }
        return true;
    }

    public function likes()
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function reply()
    {
        return $this->hasMany('App\Comment');
    }

  
}
