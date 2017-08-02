@component('mail::message')

{{$data['gardener']->member->fullname()}} has added some community hours via email.
@component('mail::table')
|  Hours | Date     | Description  |
| -------| ---------| -------------|
@foreach ($data['hours'] as $hours)
|{{$hours->hours}} hrs |{{$hours->starttime->format('M jS, Y') }}  | {{$hours->description}}|
@endforeach
@endcomponent
Sincerely

{{env('APP_NAME')}}

@endcomponent