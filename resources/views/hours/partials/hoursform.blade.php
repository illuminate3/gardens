@if (Auth::user()->can('manage_hours'))
<div class="col-sm-8">

{{Form::label('Member:')}}

<div class="form-group @if ($errors->has('members')) has-error @endif">
<select multiple="multiple" name="user[]" id="user">
@foreach($members as $member )
   
        <option value="{{$member->id}}" 
        @if( Input::old('member') == $member->id) selected="selected" @endif>{{$member->lastname}}, {{$member->firstname}}</option>
    
@endforeach
</select>

@if ($errors->has('user')) <p class="help-block">{{ $errors->first('user') }}</p> @endif
   </div>
        </div>
@endif


<div class="col-sm-8">{{Form::label('Service Date:')}}
            <div class="form-group @if ($errors->has('servicedate')) has-error @endif">
                <div class="input-group date" id="datetimepicker">
                    <input id='servicedate' name='servicedate' type="text" class="form-control" value="{{ Input::old('servicedate') }}" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                @if ($errors->has('servicedate')) <p class="help-block">{{ $errors->first('servicedate') }}</p> @endif
            </div>
        </div>
<frameset>
<legend>Enter start and end time</legend>
<div class="col-sm-3">
{{Form::label('Start Time:') }}

            <div class="form-group @if ($errors->has('starttime')) has-error @endif">
                <div class="input-group date" id="datetimepicker2">
                    <input name='starttime' type="text" class="form-control" value="{{ Input::old('starttime') }}" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                 @if ($errors->has('starttime')) <p class="help-block">{{ $errors->first('starttime') }}</p> @endif
            </div>
        </div>
        
       
  <div class="col-sm-3">  
{{Form::label('End Time:')}}

           <div class="form-group @if ($errors->has('endtime')) has-error @endif">
                <div class="input-group date" id="datetimepicker3">
                    <input name='endtime' type="text" class="form-control" value="{{ Input::old('endtime') }}" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                @if ($errors->has('endtime')) <p class="help-block">{{ $errors->first('endtime') }}</p> @endif
            </div>
        </div>

    
</frameset>
<frameset>
<legend> or Enter Hours worked</legend>
<div class="col-sm-8">
{{Form::label('Hours:')}}

<div class="form-group @if ($errors->has('hours')) has-error @endif">

{{Form::text('hours',Input::old('hours'))}}
@if ($errors->has('hours')) <p class="help-block">{{ $errors->first('hours') }}</p> @endif
</div>
</div>


</frameset>
<div class="col-sm-8">
{{Form::label('Description:')}}

<div class="form-group @if ($errors->has('description')) has-error @endif">

{{Form::textarea('description',Input::old('description'))}}
@if ($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
</div>
</div>
@if (!Auth::user()->can('manage_hours')) 
	@if (count ($members->plots[0]->managedBy) > 1)

        <div class="col-sm-8">
    {{Form::label('Worked By:')}}
    
    <div class="form-group @if ($errors->has('user')) has-error @endif">
    
   


    <select multiple="multiple" name="user[]" id="user">
     @foreach($members->plots[0]->managedBy as $member )
       
            <option value="{{$member->user_id}}" 
            @if( Input::old('member') == $member->user_id or $member->user_id==Auth::id()) selected="selected" 
            @endif>
            {{$member->firstname}}
            </option>
       
    @endforeach
    </select>
    
    
    @if ($errors->has('user')) <p class="help-block">{{ $errors->first('user') }}</p> @endif
    </div>
    </div>
    @else
    <input type='hidden' name='user[]' value ='{{Auth::id()}}' />

	@endif
@endif
