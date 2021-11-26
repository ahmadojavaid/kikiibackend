<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    protected $table = "user_reports";

    protected $fillable = ['post_id','report_by','user_id'];

    public function user()
    {
        return $this->belongsTo('App\User','report_by');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function report()
    {
        return $this->belongsTo('App\Report');
    }
}
