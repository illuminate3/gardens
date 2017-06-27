@extends('site.layouts.default')

    @section('content')
    <?php $fields = ['Username'=>'username','Member Name'=>'fullname','Roles'=>'role','Actions'=>'actions'];?>
	@can('manage_members')
		
			
	@endcan	
	
    <h1>Users</h1>
    @can('manage_members')
        <div class="pull-right">
        <a href="{{{ route('users.create') }}}" class="btn btn-small btn-info iframe">
        <span class="glyphicon glyphicon-plus-sign"></span> Add User</a>
    </div>
	@endcan
    <table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>
        <thead>
            <tr>
                @foreach ($fields as $key=>$field)
                <th>{{$key}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{$user->username}}</td>
                <td>{{$user->member->fullname()}}</td>
                <td>
                    @foreach($user->roles as $role)
                    {{$role->name}}<br />
                    @endforeach
                </td>
                <td>
                @include('partials/_modal')

                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">

                            <li><a href="{{route('users.edit',$user->id)}}"><i class="glyphicon glyphicon-pencil"></i> Edit {{$user->member->fullname()}}</a></li>
                            <li><a data-href="{{route('users.destroy',$user->id)}}" data-toggle="modal" data-target="#confirm-delete" data-title = " this user" href="#"><i class="glyphicon glyphicon-trash"></i> Delete {{$user->member->fullname()}}</a></li>
                        </ul>
                    </div>
                    </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    @include('partials._scripts')
@endsection