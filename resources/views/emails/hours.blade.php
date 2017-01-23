<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
    
		<h2>Thanks for adding your hours</h2>
		<div>
Thanks for posting your hours by email.
        <p>Hours</p>
       
		<p>{{$user->firstname}} {{$user->lastname}} has added some community hours.</p>
        <h4>{{$comments->subject}} / {{$comments->title}}</h4>
        <p><em>{{$comments->comment}}</em></p>
        <hr />
        
         You can edit the hours at <a href="{{route('hours.edit',$hours->id)}}" >this link</a></p>
       <p> Sincerely</p>
        
        <p>McNear Community Gardens</p>
		</div>
	</body>
</html>