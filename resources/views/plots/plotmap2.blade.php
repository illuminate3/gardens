@extends ('site.layouts.default')
@section('content')
    <h1>Plot Map</h1>

<p><a href="{{route('plotlist')}}" >See Plot List</a></p>
<?php
$dd='';
			echo "<style>";
			foreach($plots as $plot){
				
				
		$multiplier = 5;	
		$xoffset = 50;
		$yoffset = 25;
	
				 $left = ($plot->col * $multiplier ) + $yoffset;
				 $top = ($plot->row * $multiplier ) + $xoffset;
				 $length = $plot->width * $multiplier;
				 $width = $plot->length * $multiplier;
				 $location = $plot->row.$plot->col;
				 $title = "Plot " . $plot->plotnumber . "/". $plot->subplot;
				 $title.=$plot->description ? "<br />". $plot->description : '';
				 $dd.="<div id=\"pic".$plot->id."\" class=\"plot\">
				 <a name=\"".$location."\" id=\"".$location."\"  href=\"plots/".$plot->id."\">
				<span>".$title."</span></a>
				</div>\r\n";
				 echo "#imap #pic".$plot->id ."{position:absolute;left:".$left ."px;width:".$width."px;height:".$length."px;top:".$top."px;border:solid 1px red; z-index:20;}\r\n";
				 
				 
			 }
			echo "</style>";
			echo "<div id=\"imap\">";
			echo $dd;
			echo "</div>";
			?>
			
{{-- Scripts --}}
@include('partials._scripts')
@stop