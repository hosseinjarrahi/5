@extends('Quizviran::layout')
@section('title','تیزویران | اعضاء کلاس')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="bg-dark-gray col-12" style="padding-top: 100px;">
                <app-panel-links-header type="{{ auth()->user()->type }}"></app-panel-links-header>
            </div>
        </div>

        <div class="row justify-content-center my-3">
            <div class="col-11 my-2 bg-dark-gray rounded">

                <div class="d-flex p-2 flex-md-row flex-column text-center">

                    <div class="p-1 bg-light mx-2 rounded d-none d-md-flex"></div>
                    <h2 class="p-0 m-0">{{ $room->name }}</h2>
                    <div class="dropdown-divider d-block d-md-none"></div>
                    <div class="d-flex ml-md-auto align-items-center flex-column flex-md-row ">
                        <div class="mx-3"><span>کد عضویت : </span><span>{{ $room->code }}</span></div>
                        <div class="dropdown-divider d-block d-md-none"></div>
                        <div class="mx-3"><span>تعداد اعضاء : </span><span>{{ $room->members()->count() }}</span></div>
                        <div class="dropdown-divider d-block d-md-none"></div>
                        <div class="mx-3"><span>ساخته شده در : </span><span>{{ $room->created_at->format('Y/m/d') }}</span></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row justify-content-center my-3">
            <div class="col-11 my-2 rounded">

                <app-content-border-box title="اعضاء کلاس">
                    <div class="row justify-content-center">
                        <div :key="index" class="m-2" v-for="(user,index) in {{ $room->members->toJson() }}" >
                            <div style="padding: 1px;border-radius: 100px;"
                                 class="d-flex p-2 bg-dark-gray flex-row mx-2 align-items-center">
                                <div class="circle bg-cover bg-light"
                                     :style="{width: '50px',height: '50px',backgroundImage: `url(${user.profile.avatar})`}"
                                ></div>
                                <div class="d-flex flex-column">
                                    <div class="ml-1">
                                        @{{ user.name }}
                                    </div>
                                    <div class="ml-1">
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
