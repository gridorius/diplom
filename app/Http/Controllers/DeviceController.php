<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;

class DeviceController extends Controller
{
    public function setValue(Device $device, $value){
        $device->setValue($value);
    }
}
