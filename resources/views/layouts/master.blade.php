<!DOCTYPE HTML>
<html>

@include('includes.head')

<body>

@include('includes.navbar')

@yield('body2')
<div class="container">


    @yield('body')


    @include('includes.footer')

</div>

</body>
</html>