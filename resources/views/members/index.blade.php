@extends('site.layouts.default')
    @section('content')
    
	@can('manage_members')
		
			<?php $fields['Edit'] ='action';
			$fields['Status']='status';?>
	@endcan	
	
    <h1>Active Members</h1>
    <p><a href="{{route('members.waitlist')}}">Show Wait List Members</a></p>
    @can('manage_members')
		    <div class="pull-right">
        <a href="{{{ route('members.create') }}}" class="btn btn-small btn-info iframe">
            <span class="glyphicon glyphicon-plus-sign"></span> Add Member</a>
    </div>
        
    
	@endcan
 
<a href="{{route('members.export')}}" title ="Export members list to Excel">Export members list to Excel</a>
<table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>
		<thead>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Phone</th>
		<th>Plots</th>
		<th>Type</th>
		<th>Roles</th>

		</thead>
		<tbody>
		@foreach($members as $member)
		<tr>
			<td class="col-md-2">
				<a href="{{route('members.show', $member->id)}}" 
				title ="See {{$member->fullName()}} details" >
				{{$member->firstname}}</a>
			</td>
			<td class="col-md-2">
				<a href="{{route('members.show', $member->id)}}" 
				title ="See {{$member->fullName()}} details" >
				{{$member->lastname}}</a>
				@if($member->email != "")
					<a href="mailto:{{$member->email}}" 
					title="Email {{$member->fullName()}}" 
					target="_blank">
					<span class="glyphicon glyphicon-envelope">  </span>
					</a>

				@endif
			</td>
			<td>{{$member->phone}}</td>
			<td>
				@if(isset($member->user->roles) && count($member->user->roles)>0)
					<ul>
					@foreach ($member->user->roles as $role)
						<li>{{$role->name}}</li>
					@endforeach
					</ul>	
				@endif
			</td>
			<td>
				@if(isset($member->plots)) 
				<ul>
				@foreach ($member->plots as $plot)
					<li>{{$plot->type}}</li>
				@endforeach
				</ul>
				@endif
			</td>
			<td>	
				@if(isset($member->plots)) 
					@foreach ($member->plots as $plot)
						<a href="{{route('plots.show',$plot->id)}}"
						title ='Check out the details of this plot'>
						{{$plot->plotnumber}}  / {{$plot->subplot}} </a><br />
					@endforeach
				@endif
			</td>         
			@if(auth()->user()->hasRole('admin'))
				<td>
					<div class="btn-group">
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu" role="menu">

					<li><a href="{{route('members.edit',$member->id)}}"><i class="glyphicon glyphicon-pencil"></i> Edit {{$member->firstname}}'s details</a></li>
					     <li><a data-href="{{route('members.destroy',$member->id)}}" data-toggle="modal" data-target="#confirm-delete" 
					     data-title = " {{$member->firstname}}" 
					     href="#">
					     <i class="glyphicon glyphicon-trash"></i> Delete {{$member->firstname}}</a></li>
					</ul>
					</div>



				</td>
			@endif

			</tr>
		@endforeach

	</tbody>
</table>
{{-- Scripts --}}
@include('partials/_modal')
@include('partials._scripts')
@endsection
