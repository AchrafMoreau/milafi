<!DOCTYPE html>
<html dir='rtl' lang='ar'>
<head>
    <!-- <meta charset="UTF-8"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title >@lang('translation.sessionSchedule')</title>
    <style>
        @font-face {
            font-family: "Deja Vu Sans";
            src: url("../fonts/DejaVuSans.ttf") format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        * { 
            direction: rtl;
        }
        body > * {
            font-family: "Deja Vu Sans";
            font-size: .7rem;
            direction: rtl;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            direction: rtl;
        }
        table, th, td {
            direction: rtl;
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
            text-align: center;

        }
        .header{
            display: flex;
            justify-content: center;
        }
        #header{
            display:flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div id="header" style="width: 100%; border-collapse: collapse;">
        <h1 style="width: 100%; text-align: center;">@lang('translation.weekSchedule')</h1>
    </div>
    @foreach($schedule as $date => $procedures)
        <h2 class='header' >{{ $date }} </h2>
        <table>
            <thead>
                <tr>
                    <th>@lang('translation.time')</th>
                    <th>@lang('translation.type')</th>
                    <th>@lang('translation.description')</th>
                    <th>@lang('translation.location')</th>
                    <th>@lang('translation.title')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($procedures as $procedure)
                    <tr>
                        <td>{{ $procedure['time'] }}</td>
                        <td>@lang('translation.'. $procedure['type'])</td>
                        <td>{{ $procedure['description'] }}</td>
                        <td>{{ $procedure['location'] }}</td>
                        <td>{{ $procedure['title'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
