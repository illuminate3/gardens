		<table>
		<tr>
		<td>Gardener</td>
		<td>Date</td>
		<td>Hours</td>
		<td>Description</td>
		
		
		</tr>
		@foreach ($hours as $hour)
		
		<tr>
		<td>{{$hour->gardener}}</td>
		<td>{{date("Y-m-d",strtotime($hour->servicedate))}}</td>
		<td>{{$hour->hours}}</td>
		<td>{{$hour->description}}</td>
		</tr>
		@endforeach
		</table>