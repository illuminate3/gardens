@component('mail::message')
## New Hours Posted

{{$data['userinfo']->member['firstname']}} {{$data['userinfo']->member['lastname']}} has added some community hours.</p>
		

@component('mail::table')
|  Hours | Date     | Description  |
| -------| ---------| -------------|
@foreach ($data['hours'] as $hour)
|{{$hour['hours']}} hrs |{{date('M jS, Y',strtotime($hour['servicedate']) )}}  | {{$hour['description']}}|
@endforeach
@endcomponent


Sincerely,<br>
{{ config('app.name') }}
@endcomponent
