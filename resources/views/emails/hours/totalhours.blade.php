@component('mail::message')
<?php $total = '';?>
##Total Hours Year to Date
Hi {{$data['userinfo']->member->firstname}}:

Here are the recorded hours for your plot in {{date('Y')}}:

      
@component('mail::table')
|  Hours | Date   | Description  | Posted by|
| -------| -------| -------------| ---------|
@foreach ($data['hours'] as $hour)
|{{$hour['hours']}} hrs |{{$hour['starttime']->format('M jS, Y')}}  | {{$hour['description']}}|{{$hour->gardener->firstname}}|
<?php $total = $total + $hour['hours'];?>
@endforeach
|{{number_format($total,1)}} hrs| |Total hours|
@endcomponent
      
You can edit your hours at [this link]({{route('hours.index')}}).

Sincerely

{{env('APP_NAME')}}
@endcomponent