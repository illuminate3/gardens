@component('mail::message')
##Instructions to Submit Community Hours by Email
       
Hi {{$data['userinfo']->member->firstname}}.

Here are the instructions to submit your community hours to the McNear Community Gardens website by email.

Create an email with the text body including the hours that you want to record on separate lines. 

Each line should have the service date in the mm/dd/yy format e.g. 03/15/17 or 3/7/17 , followed by at least one space. 

Enter the number of hours (e.g. 2.5 or 0.5). <i>Don’t add the word hours and don’t use fractions (e.g 2 1/4).  Decimal only!</i>. 

Follow the hours with another space or more and then a description of the work you did. 

* Date in the format mm/dd/yy followed by at least one space.
* The number of hours in decimal notation e.g. 2.5 or 0.5 
* At least one space.
@if(count($data['userinfo']->member->plots[0]->managedBy)>1)
* An optional asterisk to indicate that the hours apply to @foreach ($data['userinfo']->member->plots[0]->managedBy as $member) {{$member->firstname}} @if($loop->remaining != 0) and @endif @endforeach 
* at least one space.
@endif
* A description of the activities 
* A line break / carriage return / new line.

The email must be sent from your {{$data['userinfo']->email}} email address otherwise it will be ignored.
####Example
@component('mail::panel')
To: hours@mcneargardens.com<br />
Subject: Hours <i>(note any subject other than Help or Total is acceptable)</i><br />
Here are my hours for March: <i>(note this text is completely optional)</i><br />
@if(count($data['userinfo']->member->plots[0]->managedBy)>1)
3/6/17  2  *  Weeded the habitat garden <i>(note the asterisk that means that @foreach ($data['userinfo']->member->plots[0]->managedBy as $member) {{$member->firstname}} @if($loop->remaining != 0) and @endif @endforeach will have these hours recorded for their record.)</i><br />
@else

3/6/17  2  Weeded the habitat garden<br />
@endif
3/7/17  3.25   Turned compost and watered the roses.<br />

Thanks <i>(note the salutation text and signature is completely optional)</i><br />
{{$data['userinfo']->member->firstname}}<br />
@endcomponent
You will receive a confirmation of their hours and the hours manager will receive a notification that you have added hours.

Note if you just wish to enter your total hours for each month simply choose a single date in the month e.g. 3/1/16 and submit all your hours for the month.

You will get a response from the [website]({{env('APP_URL')}}) confirming that your hours have been received and processed.  

You can add, edit, review and delete your hours at [this link]({{route('hours.index')}}).

If you want to receive a summary of your hours year to date send a message to <a href="mailto:hours@mcneargardens.com?subject=total">hours@mcneargardens.com</a> with a subject of 'Total'.  You will receive a reply with all your recorded hours for the year to date.

Sincerely

{{env('APP_NAME')}}
@endcomponent