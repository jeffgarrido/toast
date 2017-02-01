<!DOCTYPE HTML>
<html>

@include('includes.head')

<body>

<div class="container">

    @include('includes.navbar')

    <div class="container-fluid">
    @yield('body')
    </div>

    @include('includes.footer')

</div>

</body>
</html>