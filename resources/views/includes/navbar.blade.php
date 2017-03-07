<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;<li id="navCourses"><a href="/courses">Courses</a></li>
                <li id="navProfessor"><a href="/professor">Professor</a></li>
                <li id="navAdmin"><a href="/admin">Admin</a></li>
                <li id="navOrganization"><a href="/organization">Organizations</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/logout">Logout</a>
                                {{--{{ Form::open(array('url' => array('logout'), 'method' => 'POST')) }}--}}
                                    {{--<button type="submit">Logout</button>--}}
                                {{--{{ Form::close() }}--}}
                            </li>
                        </ul>
                    </li>
                    {{--<div class="dropdown">--}}
                        {{--<script>--}}

                            {{--// Close the dropdown menu if the user clicks outside of it--}}
                            {{--window.onclick = function(event) {--}}
                                {{--if (!event.target.matches('.dropbtn')) {--}}

                                    {{--var dropdowns = document.getElementsByClassName("dropdown-content");--}}
                                    {{--var i;--}}
                                    {{--for (i = 0; i < dropdowns.length; i++) {--}}
                                        {{--var openDropdown = dropdowns[i];--}}
                                        {{--if (openDropdown.classList.contains('show')) {--}}
                                            {{--openDropdown.classList.remove('show');--}}
                                        {{--}--}}
                                    {{--}--}}
                                {{--}--}}
                            {{--}--}}
                        {{--</script>--}}
                        {{--<div class="dropdown-content" id="myDropdown">--}}
                            {{--<a href="{{ url('/logout') }}"--}}
                               {{--onclick="event.preventDefault();--}}
                               {{--document.getElementById('logout-form').submit();">--}}
                                {{--Logout--}}
                            {{--</a>--}}

                            {{--<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">--}}
                                {{--{{ csrf_field() }}--}}
                            {{--</form>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                @endif
            </ul>
        </div>
    </div>
</nav>