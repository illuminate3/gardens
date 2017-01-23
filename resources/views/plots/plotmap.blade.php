@extends ('site.layouts.default')
@section('content')
    <h1>Plot Map!</h1>
    
   <style type="text/css" media="screen">
    canvas, img { display:block; margin:1em auto; border:1px solid black; }
    canvas { background:url({{asset('/assets/images/McNear.png')}});background-repeat:no-repeat; }
  </style>
    <canvas id="ex1" width="400" height="1200"
           style="border: 1px solid #cccccc;">
    HTML5 Canvas not supported
</canvas>




{{-- Scripts --}}
<script>

    // 1. wait for the page to be fully loaded.
    window.onload = function() {
        drawExamples();
		
		
		
    }
	function writeMessage(context, message){
                context.font = "18pt Calibri";
                context.fillStyle = "black";
                context.fillText(message, 10, 25);
            }

    function drawExamples(){
    
        // 2. Obtain a reference to the canvas element.
        var canvas  = document.getElementById("ex1");

        // 3. Obtain a 2D context from the canvas element.
        var context = canvas.getContext("2d");

        // 4. Draw graphics.
        context.fillStyle = "#ffffff";
		context.strokeStyle = "#ff0000"; 
		context.lineWidth = 1;
		var multiplier = 5;	
		var xoffset = 70;
		var yoffset = 50;		
		
		@foreach($plots as $plot)

			
			var y = (({{$plot->row}} * multiplier) + yoffset);
			var x = (({{$plot->col}} * multiplier) + xoffset);
			var length = (({{$plot->length}} * multiplier));
			var width = (({{$plot->width}} * multiplier));
			

      		context.beginPath();
			context.rect(x,y,length,width);
     
			context.stroke();
			context.fillText("Plot {{$plot->plotnumber}} ", x, y);
		@endforeach

    }

	
</script>



@stop