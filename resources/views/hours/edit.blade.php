@extends ('site.layouts.default')


@section('content')
<h1>Update your hours</h1>
<form method="post" action = "{{route('hours.update',$hour->id)}}" >
<input type="hidden" name="_method" value="patch" />
{{csrf_field()}}
@include('hours.partials.hoursform')
<input type="submit" name="submit" class="btn btn-info" value="Update Hours" />
</form>
@include('partials._scripts')
@stop