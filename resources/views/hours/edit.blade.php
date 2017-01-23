@extends ('site.layouts.default')


@section('content')
<h1>Update your hours</h1>
{{Form::model($hour, ['method'=>'PATCH','route'=>['hours.update', $hour->id]]) }}
{{Form::label('Service Date:')}}

<div class="col-sm-6">
            <div class="form-group @if ($errors->has('servicedate')) has-error @endif">
                <div class="input-group date" id="datetimepicker">
                    <input id='servicedate' name='servicedate' type="text" class="form-control" value="{{ date('m/d/Y',strtotime($hour->servicedate)) }}" />
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
                    <input name='starttime' type="text" class="form-control" value="{{  date('h:i a',strtotime($hour->starttime)) }}" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
                 @if ($errors->has('starttime')) <p class="help-block">{{ $errors->first('starttime')  }}</p> @endif
            </div>
        </div>
        
       
  <div class="col-sm-3">  
{{Form::label('End Time:')}}

           <div class="form-group @if ($errors->has('endtime')) has-error @endif">
                <div class="input-group date" id="datetimepicker3">
                    <input name='endtime' type="text" class="form-control" value="{{  date('h:i a',strtotime($hour->endtime))}}" />
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

{{Form::text('hours',$hour->hours)}}
@if ($errors->has('hours')) <p class="help-block">{{ $errors->first('hours') }}</p> @endif
</div>
</div>


</frameset>


<div class="col-sm-8">
{{Form::label('Description:')}}

<div class="form-group @if ($errors->has('description')) has-error @endif">

{{Form::textarea('description',$hour->description)}}
@if ($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
</div>
</div>
<div class="col-sm-8">
<div class="form-group">
{{Form::submit('Update',array('class'=>'btn btn-primary'))}}
</div></div>
{{Form::hidden('id',$hour->id)}}

{{Form::hidden("plot_id",$plot->id)}}	

{{Form::close()}}
@include('partials._scripts')
@stop