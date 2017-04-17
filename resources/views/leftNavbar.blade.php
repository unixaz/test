
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
    @unless (Auth::guest())
    <div class="sidebar-nav">
        <ul class="nav">

            <li class="active">

            @if (Auth::user()->isAdmin())
                <li>
                    <a href="{{ url('writeNews') }}"><i class="fa fa-newspaper-o fa-fw"></i> Skelbti naujieną</a>
                </li>
                <li>
                    <a href="{{ url('confirmUser') }}"><i class="fa fa-users fa-fw"></i> Patvirtinti vartotojus</a>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-youtube-play fa-fw"></i>
                        Video nustatymai
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('upload') }}"> Įkelti video</a></li>
                        <li><a href="{{ url('addVideo') }}"> Pridėti video</a></li>
                        <li><a href="{{ url('changeOwner') }}"> Keisti video savininką</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('deleteVideo') }}"> Trinti video</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('toggleStreaming') }}"><i class="fa fa-toggle-on fa-fw"></i> Rodyti/slėpti YouTube transliaciją</a>
                </li>

                <li class="nav-divider"></li>
            @endif


            @if (Auth::user()->isAdminOrProfessor())

                <li>
                    <a href="{{ url('myVideos') }}"><i class="fa fa-youtube-play fa-fw"></i> Mano video</a>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-lock fa-fw"></i>
                        Video privatumas
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('changePrivacy') }}"> Keisti video privatumą</a></li>
                        <li><a href="{{ url('videoPermissions') }}"> Privačių video teisės</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-list fa-fw"></i>
                        Grojaraščių nustatymai
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('createPlaylist') }}"> Kurti grojaraštį</a></li>
                        <li><a href="{{ url('assignToPlaylist') }}"> Priskirti video grojaraščiui</a></li>
                        <li><a href="{{ url('deleteFromPlaylist') }}"> Pašalinti video iš grojaraščio</a></li>
                        <li><a href="{{ url('changeVideoOrder') }}"> Keisti video pozicijas grojaraštyje</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('deletePlaylist') }}"> Trinti grojaraštį</a></li>
                    </ul>
                </li>
            @endif

        </ul>
    </div>
    @endunless
</div>


