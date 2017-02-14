@extends ('site.layouts.default')


@section('content')
<h1>Check Email Parse</h1>
<form name='Posttest' method='post', action = {{url('api/emails/hours') }} >
{{csrf_field()}}
<div class="col-sm-8">
<div class="form-group">
<input type='submit' value ='Test by Post' class='btn btn-primary' />
</div></div>
</form>
<hr />

@include('partials._scripts')
@endsection