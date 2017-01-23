<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>

    	<p>{{$userinfo->member['firstname']}} {{$userinfo->member['lastname']}} has added some community hours.</p>
		

		
		
			{{$hours['hours']}} hours  on {{date('M j<\s\up>S</\s\up>, Y',strtotime($hours['servicedate']) )}}  doing {{$hours['description']}}<br />
			
		
             <p> Sincerely</p>
        
        <p>McNear Community Gardens</p>
		</div>
	</body>
</html>