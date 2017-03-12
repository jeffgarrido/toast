<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="images/x-icon" href="/images/TOAsT_Logo.jpg" />

    <title>{{ config('app.name', 'TOAsT') }}</title>

    <!-- jQuery library -->
    <script type="text/javascript" src="/js/jquery.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css"/>
    <script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom CSS -->
    <link href="/adminTheme/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/adminTheme/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- DataTables -->
    <link rel="stylesheet" href="/datatables/media/css/jquery.dataTables.css"/>
    <script type="text/javascript" src="/datatables/media/js/jquery.dataTables.js"></script>

    <!-- Dual list box -->
    <script src="/duallistbox/src/jquery.bootstrap-duallistbox.js"></script>
    <link rel="stylesheet" type="text/css" href="/duallistbox/src/bootstrap-duallistbox.css"/>

    <!-- Multiselect -->
    <script src="/multiselect/dist/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" type="text/css" href="/multiselect/dist/css/bootstrap-multiselect.css"/>

    <!-- Admin ajax -->
    <script src="/adminTheme/js/admin.js"></script>

    <!-- TOAsT css -->
    <link rel="stylesheet" type="text/css" href="/css/toast.css"/>

    <!-- Notify Js -->
    <script type="text/javascript" src="/adminTheme/notify/notify.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->
    <!--[endif]-->

    <!-- Laravel Script -->
    <script>
        window.Laravel = {{ json_encode([
            'csrfToken' => csrf_token(),
        ]) }}
    </script>

</head>