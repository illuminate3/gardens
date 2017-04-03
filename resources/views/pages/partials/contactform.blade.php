<!-- First Name -->

<div class="form-group  {{$errors->first('name') ?  'has-error' :  ''}}">
{{Form::label('name','Your Name:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('name','',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('name')}}</span>
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

{{Form::label('comments','Your Message:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::textarea('comments','',array('class'=>"form-control"))}}

<span class="error">{{$errors->first('comments')}}</span>
</div></div>
{{Form::hidden('form','Contact')}}


