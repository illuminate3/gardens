<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>

    	<p>{{$userinfo->member['firstname']}} {{$userinfo->member['lastname']}} has added some community hours via email.</p>
		
		<ul>
		@foreach ($hours as $hour)
		
			<li>{{$hour['hours']}} hours  on {{date('M j<\s\up>S</\s\up>, Y',strtotime($hour['servicedate']) )}}  doing {{$hour['description']}}</li>
			
		@endforeach
        </ul>
        <p> Sincerely</p>
        
        <p>McNear Community Gardens</p>
		</div>
	</body>
</html>