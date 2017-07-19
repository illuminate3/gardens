<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>

    	<p>Hi {{$userinfo->member['firstname']}}.</p>
        <p>This is just to confirm that you posted the following hours on the McNear Community Garden.</p>
		<p>This is the text of your email:</p>
        <blockquote>
        {{$originalText}}
        </blockquote>
        <p>This was posted as: </p>
		<ul>
		@foreach ($hours as $hour)
		
			<li>{{$hour['hours']}} hours  on {{$hour['starttime']->format('M j<\s\up>S</\s\up>, Y')}}  doing {{$hour['description']}}</li>
			
		@endforeach
        </ul>
        <p>In case there is some problem please log into the website and correct the hours there.</p>
        <p> Sincerely</p>
        
        <p>McNear Community Gardens</p>
		</div>
	</body>
</html>