@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="row-1">
            <div class="date">{{ now()->format('Y-m-d') }}</div>
            <div id="timediv" class="time"></div>
        </div>
        <div class="row-2">
        </div>
    </div>
@endsection
@push('css')
    <style>
        .box {
            width: 1200px;
            background: #fff;
            margin: auto;
            padding: 80px 50px;
            /* padding-bottom: 40px; */
            text-align: center;
        }

        .box .row-1 {
            margin-bottom: 15px;
        }

        .box .row-1 .date {
            font-weight: 700;
            font-size: 22px;
        }

        .box .row-1 .time {
            font-size: 40px;
            color: var(--black);
        }

        .box .row-2 {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .box .row-2 a {
            text-decoration: none;
        }

        .box .row-2 a:hover {
            color: #c14829;
        }

        .box .row-2 .btn-01 {
            font-size: 22px;
            width: 350px;
            height: 90px;
            border: 2px solid #CCCCCC;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5f5f5f;
            font-weight: 700;
            border-radius: 5px;
            box-shadow: 0px 0px 10px #cdcdcd;
            margin: 10px;
        }

        .box .row-2 a:hover {
            cursor: pointer;
            filter: brightness(80%);
        }

        .box .row-2 .btn-01.disabled {
            /* Add your disabled styles here */
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }

        @media (max-width: 1200px) {
            .box {
                padding: 80px 40px;
                width: 100%;
                max-width: 800px;
            }

            .box .row-1 .date {
                font-size: 18px;
            }

            .box .row-1 .time {
                font-size: 30px;
            }

            .box .row-2 .btn-01 {
                width: 300px;
                height: 80px;
                margin: 5px;
            }
        }

        @media (max-width: 768px) {
            .box {
                width: 100%;
                max-width: 500px;
                padding: 50px;
            }
        }

        @media (max-width: 576px) {
            .box {
                max-width: 360px;
            }

            .box .row-1 {
                margin-bottom: 10px;
            }

            .box .row-2 .btn-01 {
                min-width: 300px;
            }
        }
    </style>
@endpush
@push('js')
    <script>
        function checkTime(i) {
            return (i < 10) ? i : i;
        }

        function startTime() {
            const today = new Date();
            const timeZone = 'Asia/Tokyo';

            const formatter = new Intl.DateTimeFormat('en-US', {
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: false,
                timeZone,
            });

            const parts = formatter.formatToParts(today);

            const h = checkTime(parts.find(part => part.type === 'hour').value);
            const m = checkTime(parts.find(part => part.type === 'minute').value);
            const s = checkTime(parts.find(part => part.type === 'second').value);

            var timediv = document.getElementById('timediv');

            if (timediv) {
                timediv.innerHTML = h + ":" + m + ":" + s;
            }
        }

        setInterval(startTime, 1000);
        startTime();
    </script>
@endpush
