@extends ('site.layouts.default')
@section('content')


<div class="container">
<h2>Summary Hours</h2>
<p>The following message will be sent to all members. </p>
<div class="panel panel-default">
  <div class="panel-heading"><strong>Example Email</strong><br />
  <strong>To:</strong> {{implode(';',$plotemail['address'])}}  
  <strong>Subject: </strong>
  Your {{date('Y')}}  service hours</div>
  <div class="panel-body">
 @include('emails.partials.summary')
  </div>
</div>
<form method="post" action ="{{route('sendsummaryemails')}}" >
{{csrf_field()}}
<input type="submit" class="btn btn-success" name="submit" value="Send Emails" />


</form>
</div>
@endsection