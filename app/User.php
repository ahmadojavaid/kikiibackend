<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Notifiable;
use Illuminate\Support\Str;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\EnvironmentException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Media;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

//Notifications
use App\Notifications\Match;
use App\Notifications\AudioCall;
use App\Notifications\VideoCall;
use App\Notifications\PostLike;
use App\Notifications\MissedCall;
use App\Notifications\PostComment;
use App\Notifications\PostCommentReply;
class User extends Authenticatable
{

    protected $dates = ['deleted_at'];

    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'phone_verified', 'profile_pic', 'birthday', 'upgraded',
        'gender_identity', 'sexual_identity', 'pronouns', 'bio', 'relationship_status', 'height', 'looking_for',
        'drink', 'smoke', 'cannabis', 'political_views', 'religion', 'diet_like', 'sign', 'pets', 'kids',
        'facebook', 'instagram', 'tiktok', 'last_online','latitude','longitude', 'incognito', 'show_location',
        'status', 'device_token', 'device_type'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot', 'created_at', 'updated_at','deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_online' => 'datetime'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setProfilePicAttribute($file)
    {
        if ($file) {
            $name = $file->getClientOriginalName();
            $new_name = $this->id."-".time()."-".$name;
            $file->storeAs('public/media/profile_pics/', $new_name);
            $this->attributes['profile_pic'] = $new_name;
        }
    }

    public function getLastOnlineAttribute($value)
    {
        $datetime = Carbon::parse($value);
        $diffInMins = $datetime->diffInMinutes(Carbon::now());
        $diffInHrs = $datetime->diffInHours(Carbon::now());

        if ($diffInMins < 60) {
            $value = $diffInMins . ' min. ago';

        } elseif ($datetime->isToday()) {
            $value =  $diffInHrs . ' hrs. ago';

        } elseif ($datetime->isYesterday()) {
            $value =  'Yesterday';

        } else {
            $value = $datetime->diffForHumans();
        }

        return $value;
    }

    public function getProfilePicAttribute($value)
    {
        return $value ? url('public/storage/media/profile_pics/'. $value) : null;
    }

    public function generateAuthToken() {

        do {
            $token = Str::random(60);
        } while(User::where('auth_token', $token)->exists());

        $this->auth_token = $token;
        return $this;
    }

    public function addProfilePics($new_pics)
    {
        $files = [];
        foreach ($new_pics as $file) {
            $path = 'public/media/profile_pics/' . $this->id . '/';

            $name = $file->getClientOriginalName();
            $index = 1;

            do {

                $filename = $index .'-'. $name;
                $index++;

            } while (File::exists(storage_path('app/'. $path . $filename)));

            $file->storeAs($path, $filename);

            $files[] = [
                'path' => $filename,
                'user_id' => $this->id
            ];
        }

        Media::insert($files);
    }

    public function deleteProfilePics($ids)
    {
        $path = public_path('storage/media/profile_pics/'. $this->id . '/');

        $pics = Media::whereIn('id', explode(',', $ids));
        foreach ($pics->get() as $file) {
            File::delete($path . $file->path);
        }

        $pics->delete();
    }

    public function sendNotification($notification)
    {
        $this->sendDatabaseNotification($notification);

        $server_key = config('app.fcm_server_key');
        $notification = $this->device_type == 'ios'
            ? ['notification' => $notification, 'data' => $notification]
            : ['data' => $notification];
        
        $data = [
            "registration_ids" => [$this->device_token]
        ] + $notification;

        $headers = [
            'Authorization: key=' . $server_key,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, config('app.fcm_url'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_exec($ch);
    }

    public function sendDatabaseNotification($notification)
    {
        if($notification['type'] == "match"){
            $this->notify(new Match($notification));
        } elseif ($notification['type'] == "post_like") {
            $this->notify(new PostLike($notification));
        } elseif ($notification['type'] == "post_comment") {
            $this->notify(new PostComment($notification));
        }  elseif ($notification['type'] == "comment_reply") {
            $this->notify(new PostCommentReply($notification));
        } elseif ($notification['type'] == 'audio') {
            $this->notify(new AudioCall($notification));
        } elseif ($notification['type'] == 'video') {
            $this->notify(new VideoCall($notification));
        }elseif ($notification['type'] == 'missed_call') {
            $this->notify(new MissedCall($notification));
        }
    }

    public function profile_pics()
    {
        return $this->hasMany('App\Media');
    }

    public function followers()
    {
        return $this->belongsToMany('App\User', 'followers', 'following_id', 'follower_id')->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'following_id')->withTimestamps();
    }

    public function likes()
    {
        return $this->belongsToMany('App\User', 'likes_dislikes', 'user_id', 'liker_id')->withTimestamps();
    }

    public function blockedBy()
    {
        return $this->belongsToMany('App\User', 'blocked_users', 'user_id', 'blocked_by');
    }

    public function blockedUsers()
    {
        return $this->belongsToMany('App\User', 'blocked_users', 'blocked_by', 'user_id');
    }

    public function isBlocked($userId)
    {
        return (boolean) $this->blockedUsers()
            ->where('blocked_users_id', $userId)->count();
    }


    public function likedUsers()
    {
    return $this->belongsToMany('App\User', 'likes_dislikes', 'user_id', 'liker_id');
    }

    public function friends(){
         return $this->following()
            ->whereIn('following_id', $this->followers()->pluck('users.id')->toArray());
    }

    public function friends_count()
    {
        return $this->friends()->count();
    }

    public function curiosities(){
        return $this->hasMany('App\AdminSetting');
    }

    public function liked()
    {
        return $this->belongsToMany('App\User', 'likes_dislikes', 'liker_id', 'user_id')->withTimestamps();
    }

    public function dislikes()
    {
        return $this->belongsToMany('App\User', 'likes_dislikes', 'user_id', 'disliker_id')->withTimestamps();
    }

    public function filters()
    {
        return $this->hasOne('App\Filter');
    }

    public function report(){
        return $this->hasMany('App\kikiReport');
    }

    public function reportUser(){
        return $this->hasMany('App\UserReport');
    }

    public function match(){
        return $this->hasMany('App\UserMatch');
    }

    public function userlike(){
        return $this->hasMany('App\UserMatch');
    }

    public function conversations()
    {
        return $this->hasone('App\Conversation');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
