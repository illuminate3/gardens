@component('mail::message')
## Whoops!

Hi

{{$data['userinfo']->member['firstname']}} {{$data['userinfo']->member['lastname']}} submited  hours via email. However the email was not in the correct format and hasn't been posted.

This was the text of the email:

@component('mail::panel')
{{$data['originalText']}}
@endcomponent

{{$data['userinfo']->member['firstname']}} has received an email with instructions to correct this submission. 

You can contact {{$data['userinfo']->member['firstname']}} at <a href="mailto:{{$data['userinfo']->email}}">{{$data['userinfo']->email}}</a>.

Sincerely

{{env('APP_NAME')}}
@endcomponent