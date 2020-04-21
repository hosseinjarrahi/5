<!doctype html>
<html lang="en">
<head>
    <style>
        body {
            font-family: 'vazir', sans-serif;
            direction: rtl;
        }

        .rounded {
            border-radius: 5px;
        }

        .text-white {
            color: whitesmoke;
        }

        .p {
            padding: 10px;
        }

        .bg-dark {
            background: #34495e
        }

        .text-center {
            text-align: center;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<div class="rounded bg-dark p text-white text-center">
    <span>نام آزمون : </span>
    <span>{{ $quiz->name }}</span>
</div>

@foreach($users as $user)
    <div>
        <span>نام کاربر : </span>
        <span>{{ $user->name }}</span>
    </div>
    <div>
        <span>پاسخ های کاربر : </span>
{{--        @foreach($user->pivot->answers)--}}
{{--            <span>{{  }}</span>--}}
{{--        @endforeach--}}
    </div>
@endforeach
</body>
</html>