@if (auth()->user()->can('manage_hours'))
<div class="col-sm-8">

    <label for 'user'>Choose Member</label>

    <div class="form-group @if ($errors->has('members')) has-error @endif">
        <div class="input-group input-group-lg col-xs-4">
            <select multiple="multiple" name="user[]" id="user" class="form-control"
          >
            @foreach($members as $member )

                <option value="{{$member->id}}" 
                @if( isset($request) && $request->old('member') == $member->id) selected="selected" @endif>{{$member->fullname()}}</option>

            @endforeach
            </select>

            @if ($errors->has('user')) <p class="help-block">{{ $errors->first('user') }}</p> @endif
        </div>
    </div>
</div>
@endif


<div class="col-sm-8">
    <label for 'servicedate'>Service Date:<em> (in format m/d/y or click on calendar icon)</em></label>
            <div class="form-group @if ($errors->has('servicedate')) has-error @endif">
                <div class="input-group input-group-lg  col-xs-4 date" id="datetimepicker">
                    <input id='servicedate' required 
                    placeholder ="{{date('m/d/Y')}}" 
                    name='servicedate' type="text" class="form-control" 
                    value="{{ old('servicedate', isset($hour) ? $hour->starttime->format('m/d/Y') : '' )}}" />
                    <span class="input-group-addon"><span title="Click to set date from calendar" class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                @if ($errors->has('servicedate')) <p class="help-block">{{ $errors->first('servicedate') }}</p> @endif
            </div>
        </div>
<frameset>
<legend>Enter start and end time</legend>
<div class="col-sm-3">
<label for 'starttime'>Start Time:</label>

            <div class="form-group @if ($errors->has('starttime')) has-error @endif">
                <div class="input-group input-group-lg date" id="datetimepicker2">
                    <input name='starttime' type="text" class="form-control" 
                    value="{{old('starttime', isset($hour) ? $hour->starttime->format('H:i') :'' )}}" />
                    <span class="input-group-addon"><span title="Click to set start time from clock" class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                 @if ($errors->has('starttime')) <p class="help-block">{{ $errors->first('starttime') }}</p> @endif
            </div>
        </div>
        
       
  <div class="col-sm-3">  
<label for 'endtime'>End Time:</label>

           <div class="form-group @if ($errors->has('endtime')) has-error @endif">
                <div class="input-group input-group-lg date" id="datetimepicker3">
                    <input name='endtime' type="text" class="form-control" 
                    value="{{old('endtime', isset($hour) ? $hour->endtime->format('H:i') :'' )}}" />
                    <span class="input-group-addon"><span 
                    title="Click to set end time from clock" 
                    class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                @if ($errors->has('endtime')) <p class="help-block">{{ $errors->first('endtime') }}</p> @endif
            </div>
        </div>

    
</frameset>
<frameset>
<legend> or Enter Hours worked</legend>
<div class="col-sm-8">  
    <label for 'hours'>Hours Worked:</label>

           <div class="form-group @if ($errors->has('hours')) has-error @endif">
                <div class="input-group input-group-lg col-xs-4 " >
                    <input name='hours' type="text"  placeholder = "2.5"
                    class="form-control" 
                    value="{{ old('hours', isset($hour) ? $hour->hours : '')  }}" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                @if ($errors->has('hours')) <p class="help-block">{{ $errors->first('hours') }}</p> @endif
            </div>
        </div>



</frameset>
<div class="col-sm-8">
<label for 'description'>Description:</label>

<div class="form-group @if ($errors->has('description')) has-error @endif">
<textarea class="form-control" name='description' required >
{{old('description', isset($hour) ? $hour->description : '') }}
</textarea>
@if ($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
</div>
</div>


@if (! auth()->user()->can('manage_hours') && (! isset($hour)) && count ($members->plots[0]->managedBy) > 1) 

<div class="col-sm-8">
    <label for "member">Worked by: <em>(you can check multiple)</em></label>

    <div class="form-group @if ($errors->has('user')) has-error @endif">
        <div class="input-group input-group-lg col-xs-4">
        
            
@foreach($members->plots[0]->managedBy as $member )

<li><input type="checkbox" name="user[]" 
@if($member->user_id == auth()->user()->id) checked @endif 
value="{{$member->id}}" > {{$member->firstname}}</li>   
@endforeach

        </div>
        @if ($errors->has('user')) <p class="help-block">{{ $errors->first('user') }}</p> @endif
    </div>
</div>
@elseif(! auth()->user()->can('manage_hours'))
<input type='hidden' name='user[]' value ='{{auth()->user()->id}}' />

@endif


