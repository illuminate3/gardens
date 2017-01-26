<div id="navbar-main">
    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <p class ='brand'>McNear Community Garden</p>

            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">

                        <li {{ (Request::is('About') ? ' class="active"' : '') }}><a href="{{{ URL::to('') }}}">About</a></li>
                        <li {{ (Request::is('Calendar') ? ' class="active"' : '') }}><a href="{{{ URL::to('') }}}">Calendar</a></li>
                        <li {{ (Request::is('JoinUs') ? ' class="active"' : '') }}><a href="{{{ URL::to('') }}}">Join Us</a></li>
                        <li {{ (Request::is('Contact') ? ' class="active"' : '') }}><a href="{{{ URL::to('') }}}">Contact</a></li>
                        <li {{ (Request::is('user*') ? ' class="active"' : '') }}><a href="{{{ URL::to('/login') }}}">Members</a></li>
                    @if (Auth::check())
                        
                        <li {{ (Request::is('Notebook') ? ' class="active"' : '') }}><a href="{{{ URL::to('comment') }}}">Notebook</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <span class="glyphicon glyphicon-user"></span> {{{ Auth::user()->username }}}	<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{{ URL::to('user/settings') }}}"><span class="glyphicon glyphicon-camera"></span> Profile</a></li>
                                <li><a href="{{{ URL::to('hours') }}}"><span class="glyphicon glyphicon-time"></span> Hours</a></li>
                                
                                @if (Auth::user()->hasRole('admin'))
                                    <li>
                                        <a href="{{{ URL::to('admin') }}}">
                                            <span class="glyphicon glyphicon-dashboard"></span> Admin </a>

                                    </li>
                                    @endif
                                    <li class="divider"></li>
                                <li><a href="{{{ URL::to('user/logout') }}}"><span class="glyphicon glyphicon-share"></span> Logout</a></li>
                            </ul>
                        </li>
                        @if (App::environment() != 'production')
                            <li><a href=''>{{App::environment()}}</a>
                        @endif
                    @endif

                </ul>

                                  <!-- ./ nav-collapse -->
            </div>
        </div>
    </div>
</div>