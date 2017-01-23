

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- username -->
				<div class="form-group {{{ $errors->has('username') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="username">Username</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="username" id="username" value="{{{ Input::old('username', isset($user) ? $user->username : null) }}}" />
						{{ $errors->first('username', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ username -->

				<!-- Email -->
				<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="email">Email</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="email" id="email" value="{{{ Input::old('email', isset($user) ? $user->email : null) }}}" />
						{{ $errors->first('email', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ email -->

				<!-- Password -->
				<div class="form-group {{{ $errors->has('password') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="password">Password</label>
					<div class="col-md-10">
						<input class="form-control" type="password" name="password" id="password" value="" />
						{{ $errors->first('password', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ password -->

				<!-- Password Confirm -->
				<div class="form-group {{{ $errors->has('password_confirmation') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="password_confirmation">Password Confirm</label>
					<div class="col-md-10">
						<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" value="" />
						{{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ password confirm -->

				<!-- Activation Status -->
				<div class="form-group {{{ $errors->has('activated') || $errors->has('confirm') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="confirm">Activate User?</label>
					<div class="col-md-6">
						@if ($mode == 'create')
							<select class="form-control" name="confirmed" id="confirmed">
								<option value="1"{{{ (Input::old('confirmed', 0) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
								<option value="0"{{{ (Input::old('confirmed', 0) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
							</select>
						@else
							<select class="form-control" {{{ ($user->id === Confide::user()->id ? ' disabled="disabled"' : '') }}} name="confirmed" id="confirmed">
								<option value="1"{{{ ($user->confirmed ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
								<option value="0"{{{ ( ! $user->confirmed ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
							</select>
						@endif
						{{ $errors->first('confirm', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<!-- ./ activation status -->

				<!-- Groups -->
				<div class="form-group {{{ $errors->has('roles') ? 'error' : '' }}}">
	                <label class="col-md-2 control-label" for="roles">Roles</label>
	                <div class="col-md-6">
		                <select class="form-control" name="roles[]" id="roles[]" multiple>
		                        @foreach ($roles as $role)
									@if ($mode == 'create')
		                        		<option value="{{{ $role->id }}}"{{{ ( in_array($role->id, $selectedRoles) ? ' selected="selected"' : '') }}}>{{{ $role->name }}}</option>
		                        	@else
										<option value="{{{ $role->id }}}"{{{ ( array_search($role->id, $user->currentRoleIds()) !== false && array_search($role->id, $user->currentRoleIds()) >= 0 ? ' selected="selected"' : '') }}}>{{{ $role->name }}}</option>
									@endif
		                        @endforeach
						</select>

						<span class="help-block">
							Select a group to assign to the user, remember that a user takes on the permissions of the group they are assigned.
						</span>
	            	</div>
				</div>
				<!-- ./ groups -->
			</div>
			<!-- ./ general tab -->
<div class="tab-pane" id="tab-profile">
<!-- First Name -->

<div class="form-group {{{ $errors->has('firstname') ? 'error' : '' }}}">
{{Form::label('firstname','First Name:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('firstname',isset($member->firstname) ? $member->firstname: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('firstname')}}</span>
</div></div>

<!-- Middle Name -->
<div class="form-group {{{ $errors->has('middlename') ? 'error' : '' }}}">
{{Form::label('middlename','Middle Name:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('middlename',isset($member->middlename) ? $member->middlename: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('middlename')}}</span>
</div></div>

<!-- Last Name -->
<div class="form-group {{{ $errors->has('lastname') ? 'error' : '' }}}">
{{Form::label('lastname','Last Name:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('lastname',isset($member->lastname) ? $member->lastname: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('lastname')}}</span>
</div></div>

<!-- Address -->
<div class="form-group {{{ $errors->has('address') ? 'error' : '' }}}">
{{Form::label('address','Address:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('address',isset($member->address) ? $member->address: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('address')}}</span>
</div></div>

<!-- Phone -->
<div class="form-group {{{ $errors->has('phone') ? 'error' : '' }}}">
{{Form::label('phone','Phone:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('phone',isset($member->phone) ? $member->phone: '',array('class'=>"form-control"))}}
<span class="error">{{$errors->first('phone')}}</span>
</div></div>

<!-- Mobile Phone -->
<div class="form-group {{{ $errors->has('mobile') ? 'error' : '' }}}">
{{Form::label('mobile','Mobile:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('mobile',isset($member->mobile) ? $member->mobile: '',array('class'=>"form-control"))}}
<span class="error">{{$errors->first('mobile')}}</span>
</div></div>


<!-- Mobile Phone Carrier -->
<div class="form-group {{{ $errors->has('carrier') ? 'error' : '' }}}">
{{Form::label('carrier','Carrier:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::select('carrier',$carriers,isset($member->carrier) ? $member->carrier: '',array('class'=>"form-control"))}}
<span class="error">{{$errors->first('mobile')}}</span>
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



<!-- Plots -->
@if(isset($member->status ) && $member->status != 'wait')
<div class="form-group {{{ $errors->has('plots') ? 'error' : '' }}}">
{{Form::label('plots','Assigned Plots:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
<select  name="plots[]" id="plots">
<option>Not Assigned</option>
    @foreach($plots as $plot)
    
           	 <?php
             if(in_array($plot->id,$assigned)){
				 
            	echo "<option selected value=\"".$plot->id."\">".$plot->plotnumber." | " . $plot->subplot."</option>";
			 }else{
            	echo "<option value=\"".$plot->id."\">".$plot->plotnumber." | " . $plot->subplot."</option>";
			 }?>
         

    @endforeach
</select>



    
    
<span class='error'>{{$errors->first('plots')}}</span>
</div></div>
@endif

</div>
		</div>
		<!-- ./ tabs content -->