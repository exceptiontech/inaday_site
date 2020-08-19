<html>
<head>
    <style>
        .body {
            width:     100%;
            direction: rtl;
        }

        table td {
            border:  1px solid grey;
            padding: 10px;
        }

        .bold {
            font-weight: bold;
        }

        .browse {
            display:       inline-block;
            margin:        5px auto;
            padding:       4px 6px;
            text-align:    center;
            border-bottom: 2px solid #990000;
            text-decoration: none;
        }
        .center{
            text-align: center;
        }
    </style>

</head>
<body class="body">
<table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; border-spacing: 0;">
    <tr>
        <td class="bold">{{trans('mail.project_name')}} </td>
        <td>{{$booking->project->title}}</td>
    </tr>


    <tr>
        <td class="bold">{{trans('mail.date')}} </td>
        <td>>{{$booking->created_at}}</td>
    </tr>

    <tr>
        <td colspan="2" class="bold">{{trans('mail.offer_desc')}}</td>
    </tr>
    <tr>
        <td colspan="2">{{$booking->offer->offer}}</td>
    </tr>
    <tr>
        <td colspan="2" class="bold center">
            <a class="browse" href="{{url('/bookings/'.$booking->id)}}">
                {{trans('mail.show_booking')}}
            </a>
        </td>
    </tr>
</table>
</body>
</html>