<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
    
<p>{{implode("/",$name)}} </p>
<p>According to the McNear Community Garden records as of {{date('l jS \of F Y')}} you have contributed {{$sum}} community 
hours year to date.  The annual commitment for a {{$type}} plot is {{$type=='full' ? '24' : '12'}} hours.</p>

<p> You can check and update your hours at <a href="{{route('hours.index')}}" >this link</a></p>
<p> Sincerely</p>
        
        <p>McNear Community Gardens</p>
		</div>
	</body>
</html>