@component('mail::message')
{{$data['userinfo']->member['firstname']}} {{$data['userinfo']->member['lastname']}} has added some community hours via email.
@component('mail::table')
|  Hours | Date     | Description  |
| -------| ---------| -------------|
@foreach ($data['hours'] as $hour)
|{{$hour['hours']}} hrs |{{date('M jS, Y',strtotime($hour['servicedate']) )}}  | {{$hour['description']}}|
@endforeach
@endcomponent
Sincerely

{{env('APP_NAME')}}

@endcomponent