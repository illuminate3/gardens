<!-- First Name -->

<div class="form-group  {{$errors->first('firstname') ?  'has-error' :  ''}}">
{{Form::label('firstname','First Name:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('firstname','',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('firstname')}}</span>
</div></div>

<!-- Last Name -->

<div class="form-group  {{$errors->first('lastname') ?  'has-error' :  ''}}">
{{Form::label('lastname','Last Name:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('lastname','',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('lastname')}}</span>
</div></div>

<!-- Email -->
<div class="form-group  {{$errors->first('email') ?  'has-error' :  ''}}">

{{Form::label('email','Email:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('email','',array('class'=>"form-control"))}}

<span class="error">{{$errors->first('email')}}</span>
</div></div>


<!-- Phone -->
<div class="form-group  {{$errors->first('email') ?  'has-error' :  ''}}">

{{Form::label('phone','Phone:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('phone','',array('class'=>"form-control"))}}

<span class="error">{{$errors->first('phone')}}</span>
</div></div>

<!-- Address -->
<div class="form-group  {{$errors->first('address') ?  'has-error' :  ''}}">

{{Form::label('address','Petaluma Address:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('address','',array('class'=>"form-control"))}}

<span class="error">{{$errors->first('address')}}</span>
</div></div>

<!-- Your Message -->
<div class="form-group  {{$errors->first('yourmessage') ?  'has-error' :  ''}}">

{{Form::label('yourmessage','Your Message:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::textarea('yourmessage','',array('class'=>"form-control"))}}

<span class="error">{{$errors->first('yourmessage')}}</span>
</div></div>
{{Form::hidden('form','join')}}


