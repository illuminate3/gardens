@component('mail::message')

## Thank You {{ucwords(strtolower($user->member->firstname))}}

Thank you for confirming your application for the McNearCommunity Gardens.  

Here are the contact details we have for you: 

>First Name: {{$user->member->firstname}}
>Last Name:{{$user->member->lastname}}
>Phone:{{$user->member->phone}}  
>Address:{{$user->member->address}}
>Email:{{$user->member->user->email}}
    
{{$user->member->firstname}}

Thank you for confirming your application for the McNear Community Gardens.  You are currently on the wait list.  We will keep you posted as the list changes.  Should your plans change please email us at info@mcneargardens.com.

Thanks for your interest in McNear Community gardens and we look forward to seeing you in the gardens soon.
@endcomponent