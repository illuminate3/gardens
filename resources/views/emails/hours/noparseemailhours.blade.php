<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>

    	<p>Hi {{$userinfo->member['firstname']}}.</p>
        <p>Thanks for sending an email to hours@mcneargardens.com.</p>
		<p>Unfortunately we weren't able to parse your email and post it to your hours.  </p>
        <p>Note that emailed hours need to be written on separate lines, with the date first in the format mm/dd/yy followed by at least one space then the number of hours in the format d.dd (e.g. 2.25) then at least one space and then a description of any length.</p> 
        <p>Here's an example:</p>
        <blockquote>
        <hr />
            <p>Please add the following to my hours list:</p>
                <p>3/1/15 2.5 Weeding the childrens garden</p>
                <p>3/7/15 1 Turning the compost</p>
       		<p>Thanks </p>
        <hr />
        </blockquote>
        
        <p>This was the text of your email:</p>
        <blockquote>
        <hr />
        	{{$originalText}}
            <hr />
        </blockquote>
        <p>You can either resend your email in the correct format or log into the website and correct the hours there.</p>	
        
        <p> Sincerely</p>
        
        <p>McNear Community Gardens</p>
		</div>
	</body>
</html>