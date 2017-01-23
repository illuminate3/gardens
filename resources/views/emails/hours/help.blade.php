<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
    
		<h2>Instructions to Submit Community Hours by Email</h2>
       
		<p>Hi {{$userinfo->firstname}}.</p>
       <p>Here are the instructions to submit your community hours to the McNear Community Gardens website by email.</p>
       <p>Create an email with the text body including the hours that you want to record on separate lines. Each line should have the service date in the mm/dd/yy format e.g. 03/15/15 or 3/7/15 , followed by at least one space then the number of hours (e.g. 2.5) followed by another space or more and then a description. Don’t add the word hours and don’t use fractions (e.g 2 1/4).  Decimal only!.</p>

       
<ul><li>Date in the format mm/dd/yy followed by a t least one space</li>
<li>The number of hours in decimal notation e.g. 2.5 followed by at least one space</li>
<li>An optional asterisk to indicate that the hours apply to all registered members for the plot followed by at least one space</li>
<li>A description of the activities followed by a line break.</li>
</ul>
<p>The email must come from the registered email address of the active member otherwise it will be ignored.</p>
<h4>Example</h4>
<blockquote>
<hr />
To: hours@mcneargardens.com<br />
Subject: Hours <i>(note any subject other than Help or Total is acceptable)</i><br />
Here are my hours for March: <i>(note this text is completely optional)</i><br />
3/6/16  2  *  Weeded the habitat garden <i>(note the asterisk that means all registered owners of the plot will have these hours recorded for their record.)</i><br />
3/7/16  3.25   Turned compost and watered the roses.<br />

Thanks <i>(note the salutation text and signature is completely optional)</i><br />
Stephen<br />
</blockquote>
<p>You will receive a confirmation of their hours and the hours manager will receive a notification that the member has added hours.

<p>Note if you just wish to enter your hours for each month simply choose a single date in the month e.g. 3/1/16 and submit all your hours for the month.</p>
<p>You will get a response from the website confirming that your hours have been received and processed. </p> 

<p>Send your email to <a href="mailto:hours@mcneargardens.com">hours@mcneargardens.com</a></p>
<p>You can add, edit, review and delete your hours at <a href="{{route('hours.index')}}" >this link</a></p>
       <p> Sincerely</p>
        
        <p>McNear Community Gardens</p>
		</div>
	</body>
</html>