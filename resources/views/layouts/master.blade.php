<!DOCTYPE html>
<html lang="en">

@include('includes.head')

<body>
<div id="app">

    @include('includes.navbar')
    @yield('body2')
    <div class="container">
        @yield('body')
    </div>

</div>

<!-- Scripts -->
<script src="/js/ajax.js"></script>
</body>
</html>
