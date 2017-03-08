<!DOCTYPE html>
<html lang="en">

@include('includes.head')

<body class="pullBody">

<div id="app">

    @include('includes.navbar')

    <div class="container">

        @yield('body')

    </div>

</div>

<!-- Scripts -->
<script src="/js/ajax.js"></script>

</body>

</html>
