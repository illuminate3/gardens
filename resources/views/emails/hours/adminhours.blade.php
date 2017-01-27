<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>

    	<p> {{$result[0]->gardener->firstname}} {{$result[0]->gardener->lastname}} has updated their community hours.</p>
		
			{{$result[0]->hours}} hours  on {!! date('M j<\s\up>S</\s\up>, Y',strtotime($result[0]->servicedate) )!!}  doing {{$result[0]->description}}<br />
			
		
             <p> Sincerely</p>
        
        <p>McNear Community Gardens</p>
		</div>
	</body>
</html>