<!-- Navbar -->
		<div class="navbar navbar-default navbar-inverse navbar-fixed-top">
        <div style="width:10;position:relative;float:left">
        <ul class="nav navbar-nav"><li><a href="{{{ URL::to('/') }}}"><span class="glyphicon glyphicon-home"></span> Home</a></li></ul>
        
        </div>
			 <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
						
                        <li {{ (Request::is('About') ? ' class="active"' : '') }}><a href="{{{ URL::to('/#about') }}}">About</a></li>
                        <li {{ (Request::is('Contact') ? ' class="active"' : '') }}><a href="{{{ URL::to('/contact_us') }}}">Contact</a></li>
                        @if(!Auth::check())
                        <li {{ (Request::is('Contact') ? ' class="active"' : '') }}><a href="{{{ URL::to('/join') }}}">Join Us</a></li>
                       
                        <li {{ (Request::is('user*') ? ' class="active"' : '') }}><a href="{{{ URL::to('/login') }}}">Members</a></li>
                    	@else                     
                     
                     	<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                Members Area	<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                             	<li><a href="{{{ route('members.index') }}}"><span class="glyphicon glyphicon-camera"></span> Member List</a></li>
                                <li><a href="{{{ route('members.waitlist') }}}"><span class="glyphicon glyphicon-time"></span> Wait List</a></li>
                                <li><a href="{{{ route('plots.index') }}}"><span class="glyphicon glyphicon-camera"></span> Plots</a></li>
                                <li><a href="{{{route('hours.all') }}}"><span class="glyphicon glyphicon-time"></span> Hours</a></li>
                                    
                            </ul>
                        </li>
                        
                        
                        
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <span class="glyphicon glyphicon-user"></span> {{{ Auth::user()->username }}}	<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{{ URL::to('user/settings') }}}"><span class="glyphicon glyphicon-camera"></span> Profile</a></li>
                            
                                
                                @if (Auth::user()->hasRole('admin'))
                                    
                                    <li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-user"></span> Users</a></li>
    							<li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}>
                                <a href="{{{ URL::to('manage-roles') }}}"><span class="glyphicon glyphicon-user"></span> Roles</a></li>
                                <li{{ (Request::is('summary') ? ' class="active"' : '') }}>
                                <a href="{{route('hourssummary') }}"><span class="glyphicon glyphicon-time"></span> Summary Hours</a></li>
                                   
                                <li{{ (Request::is('hours/matrix') ? ' class="active"' : '') }}><a href="{{{ URL::to('hours/matrix') }}}"><span class="glyphicon glyphicon-time"></span> Hours</a></li>
                                    @endif
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{{ url('/logout') }}" 
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                        <span class="glyphicon glyphicon-share"></span> Logout
                                        </a>
                                        <form id="logout-form" 
                                            action="{{ url('/logout') }}" 
                                            method="POST" 
                                            style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                </li>
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
