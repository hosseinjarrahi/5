@extends('Quizviran::layout')
@section('title','تیزویران | تایید نظرات')

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

                @foreach($comments as $comment)
                    <div class="card my-2">
                        <div class="card-header">
                            {{ $comment->user->name }}
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $comment->comment }}</p>
                            <a href="{{ route('quizviran.ok.comments',['comment' => $comment->id]) }}" class="btn btn-primary">تایید</a>
                            <a href="{{ route('quizviran.deleteC',['comment' => $comment->id]) }}" class="btn btn-danger">حذف</a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
@endsection
