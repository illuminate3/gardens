@if (auth()->user()->can('manage_hours'))

<div class="col-sm-8">

    <label for 'user'>Choose Member</label>

    <div class="form-group @if ($errors->has('members')) has-error @endif">
        <div class="input-group input-group-lg col-xs-4">
            <select multiple="multiple" name="user[]" id="user" class="form-control"
          >
            @foreach($members as $member )

                <option value="{{$member->id}}" 
                @if( old('member') == $member->id or auth()->user()->id == $member->id) selected @endif>{{$member->lastname}}, {{$member->firstname}}</option>

            @endforeach
            </select>

            @if ($errors->has('user')) <p class="help-block">{{ $errors->first('user') }}</p> @endif
        </div>
    </div>
</div>
@elseif (! auth()->user()->can('manage_hours') && ! isset($hour) && count ($members->plots[0]->managedBy) > 1) 

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
@else
<input type='hidden' name='user[]' value ='{{auth()->user()->id}}' />


@endif
