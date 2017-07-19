<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
	
    	<p> {{$result->gardener->fullname()}} has updated their community hours.</p>
		
			{{$result->hours}} hours  on {!! $result->starttime->format('M j<\s\up>S</\s\up>, Y')) )!!}  doing {{$result->description}}<br />
			
		
             <p> Sincerely</p>
        
        <p>McNear Community Gardens</p>
		</div>
	</body>
</html>