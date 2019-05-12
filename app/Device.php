<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DeviceType;

class Device extends Model
{
    public function type(){
        return $this->belongsTo('App\DeviceType','device_type_id', 'id');
    }

    public function setValue($value){
        $this->value = $value;
        $this->save();
    }
}
