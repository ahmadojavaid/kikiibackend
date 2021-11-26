<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $fillable = [
    	'from_age','to_age', 'distance', 'distance_in', 'height', 'gender_identity', 'sexual_identity', 'pronouns', 'relationship_status', 'diet_like', 'sign',
    	'looking_for', 'drink', 'cannabis', 'political_views', 'religion', 'pets', 'kids', 'smoke', 'last_online', 'user_id'
    ];
}
