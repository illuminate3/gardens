<!-- First Name -->

<div class="form-group">
{{Form::label('firstname','First Name:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('firstname',isset($member->firstname) ? $member->firstname: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('firstname')}}</span>
</div></div>

<!-- Middle Name -->
<div class="form-group">
{{Form::label('middlename','Middle Name:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('middlename',isset($member->middlename) ? $member->middlename: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('middlename')}}</span>
</div></div>

<!-- Last Name -->
<div class="form-group">
{{Form::label('lastname','Last Name:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('lastname',isset($member->lastname) ? $member->lastname: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('lastname')}}</span>
</div></div>

<!-- Address -->
<div class="form-group">
{{Form::label('address','Address:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('address',isset($member->address) ? $member->address: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('address')}}</span>
</div></div>

<!-- Phone -->
<div class="form-group">
{{Form::label('phone','Phone:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('phone',isset($member->phone) ? $member->phone: '',array('class'=>"form-control"))}}
<span class="error">{{$errors->first('phone')}}</span>
</div></div>

<!-- Email -->
<div class="form-group  {{$errors->first('email') ?  'has-error' :  ''}}">

{{Form::label('email','Email:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('email',isset($member->user->email) ? $member->user->email: '',array('class'=>"form-control"))}}

<span class="error">{{$errors->first('email')}}</span>
</div></div>
                
<!-- Member Since -->
 
 <div class="form-group {{$errors->first('membersince') ?  'has-error' :  ''}} ">
 {{Form::label('membersince','Member Since:',array('class'=>'col-sm-2 control-label'))}}
                <div class="col-sm-10 input-group date " id="datetimepicker">
                    <input type="text" class="form-control" name="membersince" value='{{isset($member->membersince) ? date("m/d/Y",strtotime($member->membersince)) : ''}}'/>
                    <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                   
                    <span class="error">{{$errors->first('membersince')}}</span>
                </div>
            </div>
 
 
 



<!-- Status -->
<div class="form-group  {{$errors->first('status') ?  'has-error' :  ''}}">

{{Form::label('status','status:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::select('status',
array('full'=>"Full", 'wait'=>"Wait", 'temp'=>"Temp", 'onhold'=>"OnHold", 'retired'=>"Retired"),
isset($member->status) ? $member->status : '' ,array('class'=>"form-control"))}}

<span class="error">{{$errors->first('status')}}</span>
</div></div>

<!-- Roles -->

<div class="form-group">
{{Form::label('roles','Roles:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
<select multiple="multiple" name="roles[]" id="roles">
@foreach($roles as $key=>$role)
    
<option value="{{$key}}"
{{isset($member->user->roles) && $member->user->roles->contains('id',$key) ? 'selected' : ''}}
>
    {{$role}}
</option>

         

    @endforeach
</select>
  
<span class='error'>{{$errors->first('roles')}}</span>
</div></div>



<!-- Plots -->
<div class="form-group">
{{Form::label('plots','Assigned Plots:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
<select multiple="multiple" name="plots[]" id="plots">
@foreach($plots as $key=>$plot)
    
<option value="{{$key}}"
{{isset($member->plots) && $member->plots->contains('id',$key) ? 'selected' : ''}}
>
    {{$plot}}
</option>

         

    @endforeach
</select>
  
<span class='error'>{{$errors->first('plots')}}</span>
</div></div>










