<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>
			@section('title')
			McNear Garden
			@show
		</title>
		<meta name="keywords" content="McNear Community Garden, Petaluma, Community Gardens,Gardening,Sonoma County" />
		<meta name="author" content="Stephen Hamilton, Crescent Creative,LLC" />
		<meta name="description" content="" />

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS
		================================================== -->
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.css')}}">

        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
        <link  rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.icon-large.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}" />
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.2/css/jquery.dataTables.css">

        <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />        
        <link rel="stylesheet" href="{{asset('assets/css/garden.css')}}">

        <!-- jQuery -->
        
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        
        
        <!-- Bootstrap -->
        
		<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/js/moment.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0-rc.1/js/jquery.dataTables.min.js" /></script>



<link rel="stylesheet" href="/assets/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="/assets/js/bootstrap-multiselect.js"></script>



		<style>
        body {
            padding: 60px 0;
        }
		@section('styles')
		@show
		</style>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Favicons
		================================================== -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">
		<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
	</head>

	<body>
   

		<!-- To make sticky footer need to wrap in a div -->
		<div id="wrap">
		@include ('partials/_navbar')

		<!-- Container -->
		<div class="container">
			<!-- Notifications -->
			@include('notifications')
			<!-- ./ notifications -->

			<!-- Content -->
			@yield('content')
			<!-- ./ content -->

       @if (config('app.debug') && auth()->check() && config('app.env')=='local' )
    	@include('sudosu::user-selector')
		@endif


		</div>
		<!-- ./ container -->
</div>


		<!-- the following div is needed to make a sticky footer -->
		<div id="push"></div>

		<!-- ./wrap -->


	    <div id="footer" >
	      <div class="container">
          <p><a href="{{url('privacy')}}" >Privacy Policy</a></p>
	        <p class="muted credit">&copy; 2015 - <?php echo date("Y");?>  Crescent Creative </a>.</p></div>
            
            	    </div>
          </div>


            


		<!-- Javascripts
		================================================== -->
	<!-- Javascripts -->


      

    @yield('scripts')


	</body>
</html>