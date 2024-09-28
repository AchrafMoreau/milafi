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
            margin: 0;
            margin-bottom: 10px;
            padding:0;
            font-size: .8rem;
            text-transform: capitalize;
        }
        #header{
            display:flex;
            font-size: 1rem;
            justify-content: center;
        }
        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }
        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }
        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
        .styled-table tbody tr.active-row {
            font-weight: bold;
            color: #009879;
        }
    </style>
</head>
<body>
    <div id="header" style="width: 100%; border-collapse: collapse;">
        <h1 style="width: 100%; text-align: center;">@lang('translation.weekSchedule')</h1>
    </div>
    @foreach($schedule as $date => $procedures)
        <h2 class='header' >{{ $date }} </h2>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>@lang('translation.endTime')</th>
                    <th>@lang('translation.startTime')</th>
                    <th>@lang('translation.type')</th>
                    <th>@lang('translation.description')</th>
                    <th>@lang('translation.location')</th>
                    <th>@lang('translation.title')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($procedures as $procedure)
                    <tr class=" active-row ">
                        <td>{{ $procedure['end_time'] }}</td>
                        <td>{{ $procedure['start_time'] }}</td>
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
