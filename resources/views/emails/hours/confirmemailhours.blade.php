@component('mail::message')

Hi {{$data['userinfo']->member['firstname']}}.

This is just to confirm that you posted the following hours on the McNear Community Garden website via email.

This is the text of your email:
@component('mail::panel')
{{$data['originalText']}}
@endcomponent

This was posted as: 
@component('mail::table')
|  Hours | Date   | Description  |
| -------| -------| -------------|
@foreach ($data['hours'] as $hour)
|{{$hour['hours']}} hrs |{{$hour['starttime']->format('M jS, Y')}}  | {{$hour['description']}}|
@endforeach
@endcomponent
In case there is some problem please [log into the website]({{env('APP_URL')}}) and correct the hours there.

Sincerely

{{env('APP_NAME')}}

@endcomponent
        
        