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
<div id="greywrap">
	<div class="row">
		<div class="col-lg-4 callout"><a id="about"></a>
			<img src='{{asset('assets/images/mosaic1.png')}}' />
			<h2>About Us</h2>
			<p>The McNear Community Garden in Petaluma is a group of local citizens working together to achieve the garden’s fullest potential
				while building community vitality and providing healthy food, fresh from the garden. Want to know more? Contact us today<a href="/contact_us" class="icon icon-link" style="font-size:small"> Read More</a></p>.
				</div>
                <!-- col-lg-4 -->

		<div class="col-lg-4 callout">
			<img src='{{asset('assets/images/mosaic2.png')}}' />
			<h2>Join Us</h2>
			<p>The McNear Community garden is open to all Petaluma residents.  Although we have a waiting list for plots at the moment,
				you can add your name to our list and we will be in touch with you to schedule a visit and talk about being a member.<a href="/join" class="icon icon-link" style="font-size:small"> Read More</a></p>
		</div><!-- col-lg-4 -->

		<div class="col-lg-4 callout">
			<img src='{{asset('assets/images/mosaic1.png')}}' />
			<h2>Members</h2>
			<p>Community Garden members can login here to review their profile,log your community hours and share tips and ideas with other members.<a href="/members" class="icon icon-link"  style="font-size:small"> Read More</a></p>
		</div><!-- col-lg-4 -->
	</div><!-- row -->
</div><!-- greywrap -->




<div class="container" id="contact" name="contact">
	<div class="row">
		<br>
		<h1 class="centered">THANKS FOR VISITING US</h1>
		<hr>
		<br>
		<br>
		<div class="col-lg-4">
			<h3>Contact Information</h3>
			<p><span class="icon icon-home"></span>McNear Park<br/>
				'G' and 8th Street<br/>
				Petaluma, CA 94952<br/>
				<span class="icon icon-mobile"></span> +1 650 255 7740<br/>
				<span class="icon icon-envelop"></span> <a href="mailto:info@mcneargardens.com"> info@mcneargardens.com</a> <br/>

			</p>
		</div><!-- col -->

		<div class="col-lg-4">
			<h3>Newsletter</h3>
			<p>Register to our newsletter and be updated with the latests information regarding our garden and much more.</p>
			<p>
            
            {{ Form::open(array('url' => '/news','class' => 'form-horizontal' )) }}
			
				<div class="form-group">
					<label for="inputEmail1" class="col-lg-4 control-label"></label>
					<div class="col-lg-10">
						<input type="email" class="form-control" name='email' id="inputEmail1" placeholder="Email">
					</div>
				</div>
				<div class="form-group">
					<label for="text1" class="col-lg-4 control-label"></label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="name" id="text1" placeholder="Your Name">
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10">
						<button type="submit" class="btn btn-success">Sign up</button>
					</div>
				</div>
			{{Form::close()}}<!-- form -->
			</p>
		</div><!-- col -->

		<div class="col-lg-4">
			<h3>Find Us</h3>
            <div style="margin-bottom:10px">
			<a href="https://www.google.com/maps/@38.2254821,-122.6364281,18z" title="Locate on Google Maps" target="_blank">
            <img src="https://maps.googleapis.com/maps/api/staticmap?center=38.2263,-122.637&zoom=16&size=400x200&maptype=roadmap&markers=color:green%7C38.2256,-122.6367"/></a>
            </div>
		</div><!-- col -->

	</div><!-- row -->

</div><!-- container -->
</div>
<div id="footerwrap">
	<div class="container">
     <p><a href="{{route('privacy')}}" >Privacy Policy</a></p>
		<h4>Created by <a href="http://Crescent Creative">Crescent Creative</a> - Copyright 2015</h4>
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
