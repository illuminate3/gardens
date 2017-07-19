@extends ('site.layouts.default')


@section('content')
<h1>Enter your hours</h1>

<form method="post" action="{{route('hours.store')}}" >
{{csrf_field()}}
@include('hours.partials._memberselect')
@include('hours.partials.hoursform')
<div class="col-sm-6">
<div class="form-group">
<input type="submit" name="submit" class='btn btn-primary' />
</div></div>
</form>
@include('partials._scripts')
@include('partials._datetime')
@stop