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
| {{$data['service']->hours}} hrs | {{$data['service']->starttime->format('M jS, Y')}}  | {{$data['service']->description}} |
@endcomponent


Sincerely

{{ config('app.name') }}

@endcomponent
