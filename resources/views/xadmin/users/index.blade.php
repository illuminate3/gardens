@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
	{{{ $title }}} :: @parent
@stop

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			{{{ $title }}}

			<div class="pull-right">
				<a href="{{{ URL::to('admin/users/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
		</h3>
	</div>
<table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>

		<thead>
			<tr>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.username') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.email') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.roles') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.activated') }}}</th>
				<th class="col-md-2">Last Login</th>
				<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
			</tr>
		</thead>
		<tbody>
        @foreach ($users as $user)
        	<tr><td class="col-md-2">{{$user->username}}</td>
				<td class="col-md-2">{{$user->email}}</td>
				<td class="col-md-2">
                @foreach ($user->roles as $role)
                {{$role->name}} <br /> 
                @endforeach
                </td>
				
                
                <td class="col-md-2">{{$user->confirmed == '1' ? 'Yes' : 'No'}}</td>
				<td class="col-md-2">{{$user->updated_at != '-0001-11-30 00:00:00' ? $user->updated_at : ''}}</td>
				<td class="col-md-2">
                @include('partials/_modal')

                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">

                            <li><a href="{{route('admin.users.edit',$user->id)}}"><i class="glyphicon glyphicon-pencil"></i> Edit {{$user->username}}'s details</a></li>
                                 <li><a data-href="/admin/users/{{$user->id}}/purge" data-toggle="modal" data-target="#confirm-delete" data-title = " {{$user->username}}" href="#"><i class="glyphicon glyphicon-trash"></i> Delete {{$user->username}}</a></li>
                        </ul>
                    </div>
                
               </td></tr>
        @endforeach
        

    
    </tbody>
    </table>
{{-- Scripts --}}
@include('partials._scripts')
@stop
