<!DOCTYPE html>
<html>
<head>
	<title>Roles Manager</title>
	<meta id="token" name="token" value="{{ csrf_token() }}">

	    <link href="/css/min.css" rel="stylesheet">
</head>
<body>
<div id='vuecontent'>
        @include('layouts.nav')
    @yield('content')

</div>


	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/vue.resource/0.9.3/vue-resource.min.js"></script>

	<script type="text/javascript" src="/js/role.js"></script>

</body>
</html>