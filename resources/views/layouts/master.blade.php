<!DOCTYPE HTML>
<html>

@include('includes.head')

<body>

@include('includes.navbar')

<div class="container">

    <div class="container-fluid">
        @yield('body')
    </div>

    @include('includes.footer')

</div>

</body>
</html>