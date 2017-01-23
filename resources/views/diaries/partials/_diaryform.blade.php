<!-- Title -->



<div class="form-group" class="form-group @if ($errors->has('description')) has-error @endif">
    {{Form::label('title','Title:',array('class'=>'col-sm-2 control-label'))}}
    <div class="col-sm-10">
    	{{Form::text('title',isset($diary->title) ? $diary->title: '',array('class'=>"form-control"))}}
    </div>
     @if ($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
</div>

<!-- Description -->



<div class="form-group" class="form-group @if ($errors->has('description')) has-error @endif">
    {{Form::label('notes','Diary Entry:',array('class'=>'col-sm-2 control-label'))}}
    <div class="col-sm-10">
    	{{Form::textarea('notes',isset($diary->notes) ? $diary->notes: '',array('class'=>"form-control"))}}
    </div>
     @if ($errors->has('notes')) <p class="help-block">{{ $errors->first('notes') }}</p> @endif
</div>

<!-- Activity Date-->
<div id="datepicker" class="form-group @if ($errors->has('activitydate')) has-error @endif">
{{Form::label('activitydate','Activity Date',array('class'=>'col-sm-2 control-label'))}}
   <div class="input-group date col-sm-4">       
  <input type="text" name='activitydate' class="form-control" readonly value="{{isset($diary->activitydate) ? date('m/d/Y',strtotime( 
  $diary->activitydate)) : date('m/d/Y',strtotime($cdate))}}" />
  <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
 </div> 
 @if ($errors->has('activitydate')) <p class="help-block">{{ $errors->first('activitydate') }}</p> @endif
</div>


<!-- Plot -->
@if(count($plots) >1)
<div class="form-group" class="form-group @if ($errors->has('activitytype')) has-error @endif">

{{Form::label('plot_id','Plot:',array('class'=>'col-sm-2 control-label'))}}

<div class="col-sm-10">

{{Form::select('plot_id', $plots,isset($diary->plot_id) ? $diary->plot_id : '',array('class'=>"form-control"))}}
</div>
 @if ($errors->has('plot_id')) <p class="help-block">{{ $errors->first('plot_id') }}</p> @endif
</div>
@else

{{Form::hidden('plot_id', implode('',array_keys($plots)))}}

@endif

<!-- Type -->
<div class="form-group" class="form-group @if ($errors->has('activitytype')) has-error @endif">
<?php $activitytypes = ['planted'=>'Planting','harvested'=>'Harvest','other'=>'Other'];?>

{{Form::label('activitytype','Planting / Harvesting:',array('class'=>'col-sm-2 control-label'))}}

<div class="col-sm-10">

{{Form::select('activitytype', $activitytypes,isset($diary->type) ? $diary->type : '',array('class'=>"form-control"))}}
</div>
 @if ($errors->has('activitytype')) <p class="help-block">{{ $errors->first('activitytype') }}</p> @endif
</div>


<!-- Reminder -->
<div class="form-group" class="form-group @if ($errors->has('activitytype')) has-error @endif">
{{Form::label('duration','Days to maturity / harvest:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-2">
{{Form::text('duration',isset($diary->duration) ? $diary->duration: '',array('class'=>"form-control"))}}
</div>
 @if ($errors->has('duration')) <p class="help-block">{{ $errors->first('duration') }}</p> @endif
</div>


{{Form::hidden('user_id',Auth::id())}}
