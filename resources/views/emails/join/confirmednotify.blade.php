@component('mail::message')

## {{ucwords($user->member->fullname())}} Application Completed

{{ucwords($user->member->fullname())}} has confirmed their application to join the McNear Community Gardens.  

>First Name: {{$user->member->firstname}}
>Last Name:{{$user->member->lastname}}
>Phone:{{$user->member->phone}}  
>Address:{{$user->member->address}}
>Email:{{$user->member->user->email}}

@endcomponent