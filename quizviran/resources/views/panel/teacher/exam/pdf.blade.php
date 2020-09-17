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
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $exam->name }}</title>

</head>
<body>

<div class="rounded bg-dark px-0 text-white text-center">
    <span>{{ $exam->name }}</span>
</div>

@foreach($exam->questions as $index => $question)
    <div class="container">
        <p>{!! $question->desc !!}</p>
        <p>{!! $question->A !!}</p>
        <p>{!! $question->B !!}</p>
        <p>{!! $question->C !!}</p>
        <p>{!! $question->D !!}</p>
    </div>
    <div style="border-bottom: 1px solid black;display: block;"></div>
@endforeach

@foreach($users as $user)
    <div>
        <span>نام کاربر : </span>
        <span>{{ $user->name }}</span>
    </div>
@endforeach
</body>
<script async src="https://cdn.jsdelivr.net/npm/mathjax@2/MathJax.js?config=TeX-MML-AM_SVG" media="mpdf"></script>
 </html>
