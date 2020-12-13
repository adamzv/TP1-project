<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zoznam eventov</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .invoice table {
            margin: 15px;
        }

        .invoice h3 {
            margin-left: 15px;
        }

        .information {
            background-color: #70bbd9;
            color: #FFF;
        }

        .information .logo {
            margin: 5px;
        }

        .information table {
            padding: 10px;
        }
    </style>

</head>
<body>

<div class="information">
    <table width="100%">
        <tr>
            <td align="center" bgcolor="#70bbd9" style="padding: 20px 0 10px 0;">

                <h2 style="vertical-align: middle;" width="100" height="100"><img src="pictures/logo-ukf.png" alt="Logo" style="vertical-align: middle;" width="100" height="100"
                         class="logo"/>
                    Univerzita Konštantína Filozofa v Nitre</h2>
            </td>
        </tr>

    </table>
</div>


<br/>

<div class="invoice">
    <h3>Udalosti</h3>
    @foreach($events as $event)
        <table width="100%">
            <tbody>
            <tr>
                <td width="50%">Nazov eventu:</td>
                <td width="50%"><strong>{{$event->name}}</strong></td>
            </tr>
            <tr>
                @isset($event->desc)
                    <td width="50%">Popis eventu:</td>
                    <td width="50%">{{$event->desc}}</td>
                @else
                    <td width="50%">Popis eventu:</td>
                    <td width="50%;" style="font-style: italic;">Neuvedene</td>
                @endisset
            </tr>
            <tr>
                @isset($event->room)
                    <td width="50%">Miestnost:</td>
                    <td width="50%">{{$event->room}}</td>
                @else
                    <td width="50%">Miestnost:</td>
                    <td width="50%;" style="font-style: italic;">Neuvedene</td>
                @endisset
            </tr>
            <tr>
                <td width="50%">Zaciatok eventu:</td>
                <td width="50%">{{$event->beginning}}</td>
            </tr>
            <tr>
                <td width="50%">Koniec eventu:</td>
                <td width="50%">{{$event->end}}</td>
            </tr>
            <tr>
                <td width="50%">Limit:</td>
                <td width="50%">{{$event->attendance_limit}}</td>
            </tr>
            <tr>
                <td width="50%">Lektor:</td>
                <td width="50%">{{$event->lecturer}}</td>
            </tr>
            <tr>
                <td width="50%">Event vytvoril:</td>
                <td width="50%">{{$event->user->name}} {{$event->user->surname}}</td>
            </tr>
            <tr>
                <td width="50%">Miesto konania:</td>
                <td width="50%">{{$event->place->name}}</td>
            </tr>
            <tr>
                <td width="50%">Fakuta:</td>
                <td width="50%">{{$event->faculty->name}}</td>
            </tr>
            <tr>
                @isset($event->department)
                    <td width="50%">Katedra:</td>
                    <td width="50%">{{$event->department->name}}</td>
                @else
                    <td width="50%">Katedra:</td>
                    <td width="50%" style="font-style: italic;">Vsetky</td>
                @endisset
            </tr>
            @isset($event->categories)
                <tr>
                    <td width="50%">Kategorie:</td>
                    <td width="50%">
                        @foreach($event->categories as $category)
                            {{$category->name}};
                        @endforeach
                    </td>
                </tr>
            @endisset
            </tbody>
        </table>
        <hr style="width:95%; align-content: center;">
    @endforeach
</div>

<div class="information" style="position: absolute; bottom: 0;">
    <table width="100%">
        <tr>
            <td align="left" style="width: 50%;">
                &copy; {{ date('Y') }} UKF v Nitre. Všetky práva vyhradené.
            </td>
        </tr>

    </table>
</div>
</body>
</html>
