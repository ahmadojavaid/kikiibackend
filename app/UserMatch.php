<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMatch extends Model
{
    protected $table = "user_matches";

    protected $fillable = ['user1_id', 'user2_id'];

    public function usermatch()
    {
        return $this->belongsTo('App\User','user1_id');
    }

    public function likes()
    {
        return $this->belongsTo('App\User','user2_id');
    }

   
}