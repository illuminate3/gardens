@component('mail::message')

{{$hours->gardener()->first()->fullname()}} has added some community hours via email.
@component('mail::table')
|  Hours | Date     | Description  |
| -------| ---------| -------------|

|{{$hours->hours}} hrs |{{$hours->starttime->format('M jS, Y') )}}  | {{$hours->description}}|

@endcomponent
Sincerely

{{env('APP_NAME')}}

@endcomponent