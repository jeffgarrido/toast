{{--<head>--}}

    {{--<meta charset="utf-8">--}}
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}

    {{--<title>{{ config('app.name', 'Laravel') }}</title>--}}

    {{--<!-- Latest compiled and minified CSS -->--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}

    {{--<!-- jQuery library -->--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>--}}

    {{--<!-- Latest compiled and minified JavaScript -->--}}
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}

    {{--<!-- Bootstrap -->--}}
    {{--<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css"/>--}}
    {{--<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>--}}

    {{--<!-- Toast StyleSheet -->--}}
    {{--<link rel="stylesheet" type="text/css" href="/css/toast.css"/>--}}

    {{--<link rel="stylesheet" type="text/css" href="/css/style.css"/>--}}

    {{--<!-- DataTables CSS-->--}}
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css"/>--}}

    {{--<!-- DataTables JQuery-->--}}
    {{--<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>--}}
    {{--<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>--}}
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css"/>--}}

    {{--Dual list box--}}
    {{--<script src="/bootstrap-duallistbox-master/src/jquery.bootstrap-duallistbox.js"></script>--}}
    {{--<link rel="stylesheet" type="text/css" href="/bootstrap-duallistbox-master/src/bootstrap-duallistbox.css"/>--}}

    {{--Ajax Scripts--}}
    {{--<script src="/js/ajax.js"></script>--}}

{{--</head>--}}

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- jQuery library -->
    <script type="text/javascript" src="/js/jquery.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css"/>
    <script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="/datatables/media/css/jquery.dataTables.css"/>
    <script type="text/javascript" src="/datatables/media/js/jquery.dataTables.js"></script>

    <!-- Dual list box -->
    <script src="/duallistbox/src/jquery.bootstrap-duallistbox.js"></script>
    <link rel="stylesheet" type="text/css" href="/duallistbox/src/bootstrap-duallistbox.css"/>

    <!-- Toast StyleSheet -->
    <link rel="stylesheet" type="text/css" href="/css/toast.css"/>
    <link rel="stylesheet" type="text/css" href="/css/style.css"/>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>