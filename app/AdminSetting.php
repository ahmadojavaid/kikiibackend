<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    protected $table = "admin_settings";
    protected $fillable = ['key','value'];

    protected $casts = [
        'value' => 'json'
    ];
    

    public function setValueAttrAttribute($value)
    {
        $value_attr = [];

    foreach ($value as $array_item) {
        if (!is_null($array_item['key'])) {
            $value_attr[] = $array_item;
        }
    }
        
        $this->attributes['value_attr'] = json_encode($value_attr);
        
    }


    public function getValueAttrAttribute($value)
    {
        return json_decode($value,true);
    }

   
}
