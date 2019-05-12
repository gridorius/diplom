<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;

class RoomController extends Controller
{
    public function getRooms(){
        return Room::with('devices.type')->get();
    }
}
