
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
    @unless (Auth::guest())
    <div class="sidebar-nav">
        <ul class="nav">

            <li class="active">

            @if (Auth::user()->isAdmin())
                <li>
                    <a href="{{ url('writeNews') }}"><i class="fa fa-dashboard fa-fw"></i> Skelbti naujieną</a>
                </li>
                <li>
                    <a href="{{ url('upload') }}"><i class="fa fa-dashboard fa-fw"></i> Įkelti video</a>
                </li>
                <li>
                    <a href="{{ url('addVideo') }}"><i class="fa fa-dashboard fa-fw"></i> Pridėti video</a>
                </li>
                <li>
                    <a href="{{ url('confirmUser') }}"><i class="fa fa-dashboard fa-fw"></i> Patvirtinti vartotojus</a>
                </li>
                <li>
                    <a href="{{ url('changeOwner') }}"><i class="fa fa-dashboard fa-fw"></i> Keisti video savininką</a>
                </li>
                <li>
                    <a href="{{ url('deleteVideo') }}"><i class="fa fa-dashboard fa-fw"></i> Trinti video</a>
                </li>
                <li class="nav-divider"></li>
            @endif


            @if (Auth::user()->isAdminOrProfessor())
                <li>
                    <a href="{{ url('changePrivacy') }}"><i class="fa fa-dashboard fa-fw"></i> Keisti video privatumą</a>
                </li>
                <li>
                    <a href="{{ url('videoPermissions') }}"><i class="fa fa-dashboard fa-fw"></i> Privačių video teisės</a>
                </li>


                <li>
                    <a href="{{ url('myVideos') }}"><i class="fa fa-dashboard fa-fw"></i> Mano ikelti video</a>
                </li>
                <li>
                    <a href="{{ url('createPlaylist') }}"><i class="fa fa-dashboard fa-fw"></i> Kurti grojaraštį</a>
                </li>
                <li>
                    <a href="{{ url('assignPlaylist') }}"><i class="fa fa-dashboard fa-fw"></i> Priskirti grojaraščiui</a>
                </li>
                <li>
                    <a href="{{ url('deletePlaylist') }}"><i class="fa fa-dashboard fa-fw"></i> Trinti grojaraštį</a>
                </li>
                <li>
                    <a href="{{ url('sortPlaylist') }}"><i class="fa fa-dashboard fa-fw"></i> Perdelioti grijarašti</a>
                </li>




                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-dashboard fa-fw"></i>
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
            @endif

        </ul>
    </div>
    @endunless
</div>


