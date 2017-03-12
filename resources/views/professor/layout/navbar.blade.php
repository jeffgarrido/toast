<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">{{ config('app.name', 'TOAsT') }}</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown pull-right">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <i class="fa fa-user"></i> {{ Auth::user()->name }} <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-fw fa-power-off"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li id="navAdminDashboard">
                <a href="/dashboard"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li id="navManageUsers">
                <a href="javascript:;" data-toggle="collapse" data-target="#usersSubMenu"><i class="fa fa-fw fa-users"></i> Manage Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="usersSubMenu" class="collapse">
                    <li>
                        <a href="/professors"><i class="fa fa-fw fa-male"></i> Professors</a>
                    </li>
                    <li>
                        <a href="/students"><i class="fa fa-fw fa-child"></i> Students</a>
                    </li>
                    <li>
                        <a href="/users"><i class="fa fa-fw fa-user"></i> User Accounts</a>
                    </li>
                </ul>
            </li>
            <li id="navManageCourses">
                <a href="/courses"><i class="fa fa-fw fa-book"></i> Courses</a>
            </li>
            <li>
                <a href="/classes"><i class="fa fa-fw fa-edit"></i> Classes</a>
            </li>
            <li>
                <a href="/sections"><i class="fa fa-fw fa-server"></i> Sections</a>
            </li>

        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>