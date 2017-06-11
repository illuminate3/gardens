<!-- First Name -->

<div class="form-group  {{$errors->first('firstname') ?  'has-error' :  ''}}">
	<label for 'firstname' class='col-sm-2 control-label'>First Name:</label>
	<div class="col-sm-10">
		<input required type="text" name ='firstname' class="form-control" value="{{old('firstname')}}" />
		<span class='error'>{{$errors->first('firstname')}}</span>
	</div>
</div>

<!-- Last Name -->

<div class="form-group  {{$errors->first('lastname') ?  'has-error' :  ''}}">
<label for 'lastname' class='col-sm-2 control-label'>Last Name:</label>
<div class="col-sm-10">
<input required type="text" name ='lastname' class="form-control" value="{{old('lastname')}}" />
<span class='error'>{{$errors->first('lastname')}}</span>
</div></div>

<!-- Email -->
<div class="form-group  {{$errors->first('email') ?  'has-error' :  ''}}">

<label for email' class='col-sm-2 control-label'>Email:</label>
<div class="col-sm-10">
<input required type='text' class='form-control' name='email' value="{{old('email')}}" />

<span class="error">{{$errors->first('email')}}</span>
</div></div>


<!-- Phone -->
<div class="form-group  {{$errors->first('phone') ?  'has-error' :  ''}}">

<label for phone' class='col-sm-2 control-label'>Phone:</label>
<div class="col-sm-10">
<input required type='text' class='form-control' name='phone'  value="{{old('phone')}}"/>

<span class="error">{{$errors->first('phone')}}</span>
</div></div>

<!-- Address -->
<div class="form-group  {{$errors->first('address') ?  'has-error' :  ''}}">

<label for address' class='col-sm-2 control-label' >Petaluma Address:</label>
<div class="col-sm-10">
<input required type='text' class='form-control' name='address'  value="{{old('address')}}" />

<span class="error">{{$errors->first('address')}}</span>
</div></div>

<!-- Your Message -->
<div class="form-group  {{$errors->first('comments') ?  'has-error' :  ''}}">

<label for comments' class='col-sm-2 control-label'>Your Message:</label>
<div class="col-sm-10">
<textarea class='form-control' name='comments'>{{old('comments')}}
</textarea>

<span class="error">{{$errors->first('comments')}}</span>
</div></div>
<input type='hidden' id='form' name='form' value='join' />


