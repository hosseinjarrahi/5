@extends('Quizviran::layout')
@section('title','تیزویران | اعضاء کلاس')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ $user->type }}"></app-panel-links-header>
            </div>
        </div>

        <app-panel-room-info :room="{{ $room->toJson() }}" createdat="{{ jalalyYMD($room->created_at) }}"></app-panel-room-info>

        <div class="row justify-content-center mt-5" style="margin-bottom: 150px;">
            <div class="col-11 my-2 rounded">

                <app-content-border-box title="اعضاء کلاس">
                    <div class="row justify-content-center">
                        @if($room->members->isEmpty())
                            <div class="col-11 col-md-8 d-flex flex-column text-center p-3 mt-3">
                                <span class=" display-1">
                                <span class="fas fa-user-alt-slash"></span>
                                </span>
                                <span class="blockquote ">تا کنون هیچ دانش آموزی در کلاس شما عضو نشده است!!</span>
                            </div>
                        @endif
                        <div :key="index" class="m-2" v-for="(user,index) in {{ $room->members->toJson() }}">
                            <div style="padding: 1px;border-radius: 100px;"
                                 class="d-flex p-2 bg-dark-gray flex-row mx-2 align-items-center">
                                <div class="circle bg-cover bg-light"
                                     :style="{
                                     width: '50px',
                                     height: '50px',
                                     backgroundImage: `url(${ !!user.profile.avatar ? user.profile.avatar : '/img/avatar.svg' })`}"
                                ></div>
                                <div class="d-flex flex-column">
                                    <div class="ml-1">
                                        @{{ user.name }}
                                    </div>
                                    <div class="ml-1 mt-1 figure-caption">
                                        <span>امتیاز:</span>
                                        <span>@{{ user.profile.point ? user.profile.point : 0}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </app-content-border-box>

            </div>
        </div>

    </div>
@endsection
<script>
    import AppPanelRoomInfo from "../../../../js/components/room/AppPanelRoomInfo";
    export default {
        components: {AppPanelRoomInfo}
    }
</script>
