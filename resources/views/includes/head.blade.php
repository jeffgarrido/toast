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