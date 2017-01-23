@extends ('site.layouts.default')
@section('content')
<h1>Contact McGardens</h1>

{{form::('contact',route('page.contact')}}
<!-- Your Name -->
<div class="form-group">
{{Form::label('yourname','Your Name:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('yourname',,array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('yourname')}}</span>
</div></div>
<!-- Your EMail -->
<div class="form-group">
{{Form::label('youremail','Your Email:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('youremail',,array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('youremail')}}</span>
</div></div>
<!--Your Comments -->
<div class="form-group">
{{Form::label('yourcomments','Your Comments:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::textarea('yourcomments',,array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('yourcomments')}}</span>
</div></div>

{{form::submit()}}
{{form::close()}}