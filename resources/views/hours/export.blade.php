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
		<td>{{$hour->starttime->format("Y-m-d")}}</td>
		<td>{{$hour->hours}}</td>
		<td>{{$hour->description}}</td>
		</tr>
		@endforeach
		</table>