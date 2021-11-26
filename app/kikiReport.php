<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class kikiReport extends Model
{

	protected $table='reports';
    protected $fillable = ['title', 'text','user_id'];

    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
