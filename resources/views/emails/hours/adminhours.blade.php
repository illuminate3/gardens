@component('mail::message')
## New Hours Posted

@foreach($data['gardener'] as $gardener)
{{$gardener->member()->first()->fullname()}} @if(! $loop->last) and @endif
@endforeach
@if(count($data['gardener'])>1)
	have 
@else
	has 
@endif
added some community hours.</p>
		

@component('mail::table')
|  Hours | Date     | Description  |
| -------| ---------| -------------|
@foreach($data['service'] as $hours)
| {{$hours->hours}} hrs | {{$hours->starttime->format('M jS, Y')}}  | {{$hours->description}} |
@endforeach
@endcomponent


Sincerely

{{ config('app.name') }}

@endcomponent
