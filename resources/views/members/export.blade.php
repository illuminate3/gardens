		<table>
		<tr>
		<td>Name</td>
		<td>Phone</td>
		<td>Mobile</td>
		<td>Email</td>
		<td>Status</td>
		<td>Membersince</td>
		<td>Plot / Type</td>
		
		</tr>
		@foreach ($members as $member)
		
		<tr>
		<td>{{$member->firstname}}	{{$member->lastname}}</td>
		<td>{{$member->phone}}</td>
		<td>{{$member->mobile}}</td>
		<td>
		@if(isset($member->userdetails->email))
		{{$member->userdetails->email}}
		@endif
		</td>
		<td>{{$member->status}}</td>
		<td>{{$member->membersince}}</td>
		<td>
		@foreach ($member->plots as $plot)
		{{$plot->plotnumber}} / {{$plot->subplot}} - {{$plot->type}}
		@endforeach
		</td>
		</td>
		</tr>
		@endforeach
		</table>