@component('mail::message')
Hi {{$data['userinfo']->member['firstname']}}.

Thanks for sending an email to <a href="mailto:hours@mcneargardens.com?subject=hours">hours@mcneargardens.com</a>.

Unfortunately we weren't able to parse your email and post it to your hours. 

Note that emailed hours need to be written on separate lines, with the date first in the format mm/dd/yy followed by at least one space then the number of hours in the format d.dd (e.g. 2.25) then at least one space and then a description of any length.

Here's an example:

@component('mail::panel')

            Please add the following to my hours list:

                3/1/17 2.5 Weeding the childrens garden
                3/7/17 1 Turning the compost
       		Thanks 

@endcomponent
        

This was the text of your email:

@component('mail::panel')
{{$data['originalText']}}
@endcomponent

You can get the full instructions for submitting hours by email by sending a message from your {{$data['userinfo']->email}} email account to <a href="mailto:hours@mcneargardens.com?subject=help">hours@mcneargardens.com</a> with a subject of 'Help'.

You can either resend your email in the correct format or [log into the website]({{env('APP_URL')}}) and input your hours there.	
        

Sincerely
        
{{env('APP_NAME')}}
@endcomponent