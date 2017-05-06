
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
                        Vaizdo įrašų nustatymai
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('upload') }}"> Įkelti viešą vaizdo įrašą</a></li>
                        <li><a href="{{ url('uploadPrivate') }}"> Įkelti privatų vaizdo įrašą</a></li>
                        <li><a href="{{ url('addVideo') }}"> Pridėti viešą vaizdo įrašą</a></li>
                        <li><a href="{{ url('changeOwner') }}"> Keisti vaizdo įrašo savininką</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('deleteVideo') }}"> Trinti viešą vaizdo įrašą</a></li>
                        <li><a href="{{ url('deletePrivateVideo') }}"> Trinti privatų vaizdo įrašą</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('toggleStreaming') }}"><i class="fa fa-toggle-on fa-fw"></i> Rodyti/slėpti YouTube transliaciją</a>
                </li>

                <li class="nav-divider"></li>
            @endif


            @if (Auth::user()->isAdminOrProfessor())

                <li>
                    <a href="{{ url('myVideos') }}"><i class="fa fa-youtube-play fa-fw"></i> Mano vaizdo įrašai</a>
                </li>
                <li>
                    <a href="{{ url('videoPermissions') }}"><i class="fa fa-lock fa-fw"></i> Privačių vaizdo įrašų teisės</a>
                </li>

                {{--<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-lock fa-fw"></i>
                        Vaizdo įrašų privatumas
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('changePrivacy') }}"> Keisti vaizdo įrašo privatumą</a></li>
                        <li><a href="{{ url('videoPermissions') }}"> Privačių vaizdo įrašų teisės</a></li>
                    </ul>
                </li>--}}

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


