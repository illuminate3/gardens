<!-- First Name -->

<div class="form-group  {{$errors->first('yourname') ?  'has-error' :  ''}}">
{{Form::label('yourname','Your Name:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('yourname','',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('yourname')}}</span>
</div></div>

<!-- Email -->
<div class="form-group  {{$errors->first('email') ?  'has-error' :  ''}}">

{{Form::label('email','Email:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('email','',array('class'=>"form-control"))}}

<span class="error">{{$errors->first('email')}}</span>
</div></div>

<!-- Email -->
<div class="form-group  {{$errors->first('email') ?  'has-error' :  ''}}">

{{Form::label('yourmessage','Your Message:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::textarea('yourmessage','',array('class'=>"form-control"))}}

<span class="error">{{$errors->first('yourmessage')}}</span>
</div></div>
{{Form::hidden('form','Contact')}}


