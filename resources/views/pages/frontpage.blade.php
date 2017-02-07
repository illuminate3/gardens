<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="McNear Community Garden">
	<meta name="author" content="Stephen Hamilton CrescentCreative.com">
	<link rel="shortcut icon" href="{{{asset('assets/ico/favicon.png')}}}">

	<title> McNear Community Garden</title>

	<!-- Bootstrap core CSS -->
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="{{{asset('assets/css/main.css')}}}" rel="stylesheet">
	<link rel="stylesheet" href="{{{asset('assets/css/icomoon.css')}}}">
	<link rel="stylesheet" href="{{{asset('assets/css/bootstrap-datetimepicker.min.css')}}}">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.2/css/jquery.dataTables.css">
	<link rel="stylesheet" href="{{{asset('assets/css/garden.css')}}}">
	<link href="{{{asset('assets/css/animate-custom.css')}}}" rel="stylesheet">



	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

	


	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="{{{asset('assets/js/html5shiv.js')}}}"></script>
	<script src="{{{asset('assets/js/respond.min.js')}}}"></script>
	<![endif]-->
</head>

<body data-spy="scroll" data-offset="0" data-target="#navbar-main">

<div id="wrap">
	@include('partials._navbar')



<!-- ==== HEADERWRAP ==== -->
<div id="headerwrap" id="home" name="home">
	<header class="clearfix">

		<p>McNear Community Garden</p>
		<p>Petaluma, California</p>
	</header>
</div>

<!-- /headerwrap -->

<!-- ==== GREYWRAP ==== -->
{!!$page->text!!}
<div id="footerwrap">
	<div class="container">
     <p><a href="{{url('privacy')}}" >Privacy Policy</a></p>
		<h4>Created by <a href="http://Crescent Creative">Crescent Creative</a>
		 - Copyright 2015 - <?php echo date('Y');?>
		</h4>
	</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    
@include('partials._scripts')

</body>
</html>
