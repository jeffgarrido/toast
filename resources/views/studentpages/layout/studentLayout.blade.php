<!DOCTYPE html>
<html lang="en">

    @include('studentpages.layout.head')

    <body>

        <div id="app">

            <div id="wrapper">

                @include('studentpages.layout.navbar')

                @yield('body')

            </div>

        </div>

        @if(isset($nav))
            <script>
                $(document).ready(function() {
                    $('#{{ $nav }}').addClass('active');
                });
            </script>
        @endif

    </body>

</html>
