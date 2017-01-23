@extends('admin.layouts.default')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General<i class="fa"></i></a></li>

			<li><a href="#tab-profile" data-toggle="tab">Profile<i class="fa"></i></a></li>
		</ul>
	<!-- ./ tabs -->

	{{-- Create User Form --}}
	<form class="form-horizontal" method="post" action="@if (isset($user)){{ URL::to('admin/users/' . $user->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->
@include('admin.users.partials._userform');

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-offset-2 col-md-10">

				<button type="submit" class="btn btn-success">Add New User</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>
    {{-- Scripts --}}
@include('partials._scripts')
@stop
