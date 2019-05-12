@extends('layouts.app')

@section('content')
    <script>
        window.addEventListener('DOMContentLoaded', e=>{
            app.getRoomsUrl = '{{route('getRooms')}}';
            app.update();
            app.startUpdating();
        });
    </script>
    <div class="main-container">
        <div id="room_slider" class="room-slider">
            <div class="card-wrapper">
                @foreach($rooms as $room)
                    <div class="room-card" data-room-id="{{$room->id}}">
                        <div class="card-content">
                            <div class="room-name fs-36 c-white-0">{{$room->name}}</div>
                            <div class="room-image" style="background-image: url('{{asset($room->image)}}')">
                                <div class="name">{{$room->name}}</div>
                                <div class="room-description">
                                   {{$room->description}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="next" onclick="slider.next()"> > </div>
            <div class="prev" onclick="slider.prew()"> < </div>
            <div class="back" onclick="slider.close()"></div>
        </div>
        <div class="devices">
            <div class="device" v-for="item in show">
                <img :src="item.type.typeImage" alt="" class="image">
                <div class="name">@{{item.type.typeName}}</div>
                <div class="value" v-if="[2, 6].includes(item.type.id)">@{{item.value}} @{{item.type.id == 2 ? 'C°' : ''}}</div>
                <div class="value" v-else="">
                    <div :class="{changer: true, active: ['on', 'open'].includes(item.value)}" @click="changeValue(item)">
                        <div class="pointer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
