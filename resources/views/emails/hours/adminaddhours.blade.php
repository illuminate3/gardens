<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
	
    	<p> {{$result->gardener->lastname}} {{$result->gardener->lastname}} has recorded some community hours.</p>
		
			{{$result->hours}} hours  on {{date('M j<\s\up>S</\s\up>, Y',strtotime($result->servicedate) )}}  doing {{$result->description}}<br />
			
		
             <p> Sincerely</p>
        
        <p>McNear Community Gardens</p>
		</div>
	</body>
</html>