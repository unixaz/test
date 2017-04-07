
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
    <div class="sidebar-nav">
        <ul class="nav">

            <li class="active">


            @if (Auth::user() && Auth::user()->isAdminOrProfessor())
                <li>
                    <a href="{{ url('create') }}"><i class="fa fa-dashboard fa-fw"></i> Rašyti naujieną</a>
                </li>
            @endif

            @if (Auth::user() && Auth::user()->isAdminOrProfessor())
                <li>
                    <a href="{{ url('addVideo') }}"><i class="fa fa-dashboard fa-fw"></i> Pridėti video</a>
                </li>
            @endif

            @if (Auth::user() &&  Auth::user()->role == 2 )
                <li>
                    <a href="{{ url('confirm') }}"><i class="fa fa-dashboard fa-fw"></i> Patvirtinti</a>
                </li>
            @endif
            @if (Auth::user() &&  Auth::user()->role == 2 )
                <li>
                    <a href="{{ url('upload') }}"><i class="fa fa-dashboard fa-fw"></i> Ikelti video</a>
                </li>
            @endif

            @if (Auth::user() &&  Auth::user()->role == 1 )
                <li>
                    <a href="{{ url('myVideos') }}"><i class="fa fa-dashboard fa-fw"></i> Mano ikelti video</a>
                </li>
            @endif
            @if (Auth::user() &&  Auth::user()->role == 1 )
                        <li>
                            <a href="createPlaylist">Kurti grojaraštį</a>
                        </li>
                        <li>
                            <a href="assignPlaylist">Priskirti grojaraščiui</a>
                        </li>
                        <li>
                            <a href="deletePlaylist">Trinti grojaraštį</a>
                        </li>
                        <li>
                            <a href="sortPlaylist">Perdelioti grijarašti</a>
                        </li>

            @endif

            <li class="nav-divider"></li>
            <li><a href="#">Link</a></li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    Dropdown <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                </ul>
            </li>


        </ul>
    </div>
    <!--/.well -->
</div>
<!--/span-->
