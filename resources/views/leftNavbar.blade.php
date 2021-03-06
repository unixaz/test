
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
                        <a href="{{ url('groups') }}"><i class="fa fa-users fa-fw"></i> Grupių administ.</a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>
                            Vartotojų administ.
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ url('importUsers') }}">Importuoti vartotojus/grupes</a>
                            </li>
                            <li>
                                <a href="{{ url('deleteUsers') }}">Šalinti vartotojus</a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-youtube-play fa-fw"></i>
                            Vaizdo įrašų administ.
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('upload') }}"> Įkelti viešą vaizdo įrašą</a></li>
                            <li><a href="{{ url('uploadPrivate') }}"> Įkelti privatų vaizdo įrašą</a></li>
                            <li><a href="{{ url('addVideo') }}"> Pridėti viešą vaizdo įrašą</a></li>
                            {{--<li><a href="{{ url('changeOwner') }}"> Keisti vaizdo įrašo savininką</a></li>--}}
                            <li class="divider"></li>
                            <li><a href="{{ url('deleteVideo') }}"> Šalinti vaizdo įrašus</a></li>
                            {{--<li><a href="{{ url('deletePrivateVideo') }}"> Šalinti privatų vaizdo įrašą</a></li>--}}
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('toggleStreaming') }}"><i class="fa fa-toggle-on fa-fw"></i> Rodyti/slėpti YouTube transliaciją</a>
                    </li>

                    <li class="nav-divider"></li>
                @endif


                @if (Auth::user()->isAdminOrProfessor())

                    <li>
                        <a href="{{ url('generateKey') }}"><i class="fa fa-key fa-fw"></i> Registracijos raktas</a>
                    </li>
                    <li>
                        <a href="{{ url('studentsList') }}"><i class="fa fa-list-ol fa-fw"></i> Studentų sąrašas</a>
                    </li>
                    <li>
                        <a href="{{ url('myVideos') }}"><i class="fa fa-youtube-play fa-fw"></i> Mano vaizdo įrašai</a>
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
                            Grojaraščių administ.
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('createPlaylist') }}"> Kurti viešą grojaraštį</a></li>
                            <li><a href="{{ url('createPrivatePlaylist') }}"> Kurti privatų grojaraštį</a></li>
                            <li><a href="{{ url('privatePlaylistPermissions') }}"> Privačių grojaraščių teisės</a></li>
                            <li><a href="{{ url('assignToPlaylist') }}"> Pridėti vaizdo įrašą į viešą grojaraštį</a></li>
                            <li><a href="{{ url('assignToPrivatePlaylist') }}"> Pridėti vaizdo įrašą į privatų grojaraštį</a></li>
                            <li><a href="{{ url('deleteFromPlaylist') }}"> Šalinti vaizdo įrašą iš grojaraščio</a></li>
                            <li><a href="{{ url('changeVideoOrder') }}"> Keisti vaizdo įrašų pozicijas grojaraštyje</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ url('deletePlaylist') }}"> Šalinti grojaraštį</a></li>
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
    @endunless
</div>


