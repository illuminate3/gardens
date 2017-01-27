<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
    <?php $total = '';?>
		<p>Hi {{$userinfo->member->firstname}}:</p>
		<p>Here are the recorded hours for your plot in {{$year}}:</p>
        <table>
        <thead>
        <th>Date</th>
        <th>Hours</th>
        <th>Description</th>
        <th>Gardener</th>
        </thead>
        <tbody>
      
        @foreach ($hours as $hour)
        	<?php $total = $total + $hour->hours;?>
            <tr>
            <td> {!! date('M j<\s\up>S</\s\up>',strtotime($hour['servicedate']) ) !!}</td>
            <td align="right"> {{number_format($hour->hours,2)}}</td>
            <td>{{$hour->description}}</td>
            <td>{{$hour->gardener->firstname}}</td>
            </tr>
        
        @endforeach
        
        </tbody>
        <tfoot>
        <td>Total:</td>
        <td align="right">{{number_format($total,2)}}</td>
        </tfoot>
        </table>
        
        
         You can edit your hours at <a href="{{route('hours.index')}}" >this link</a></p>
       <p> Sincerely</p>
        
        <p>McNear Community Gardens</p>
		</div>
	</body>
</html>