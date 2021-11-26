<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class blockedUser extends Model
{
    protected $fillable =['user_id','blocked_by'];
}
