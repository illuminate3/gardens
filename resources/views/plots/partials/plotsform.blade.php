<!-- Plot Number -->



<div class="form-group">
{{Form::label('plotnumber','Plot Number:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('plotnumber',isset($plot[0]->plotnumber) ? $plot[0]->plotnumber: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('plotnumber')}}</span>
</div></div>

<!-- Sub plot -->
<div class="form-group">
{{Form::label('subplot','Sub Plot:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('subplot',isset($plot[0]->subplot) ? $plot[0]->subplot: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('subplot')}}</span>
</div></div>

<!-- Type -->
<div class="form-group">
{{Form::label('type','Type:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">

{{Form::select('type', array('full' => 'full', 'partial' => 'partial','common'=>'common'),isset($plot[0]->type) ? $plot[0]->type: '',array('class'=>"form-control"))}}

<span class='error'>{{$errors->first('type')}}</span>
</div></div>

<!-- Width -->
<div class="form-group">
{{Form::label('width','Width:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('width',isset($plot[0]->width) ? $plot[0]->width: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('width')}}</span>
</div></div>

<!-- Length -->
<div class="form-group">
{{Form::label('length','Length:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('length',isset($plot[0]->length) ? $plot[0]->length: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('length')}}</span>
</div></div>

<!-- Description -->

<div class="form-group">
{{Form::label('description','Description:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::textarea('description',isset($plot[0]->description) ? $plot[0]->description: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('description')}}</span>
</div></div>

<!-- X Coords-->
<div class="form-group">
{{Form::label('row','X Coords:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('row',isset($plot[0]->row) ? $plot[0]->row: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('row')}}</span>
</div></div>

<!-- Y Coords -->
<div class="form-group">
{{Form::label('col','Y Coords:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
{{Form::text('col',isset($plot[0]->col) ? $plot[0]->col: '',array('class'=>"form-control"))}}
<span class='error'>{{$errors->first('col')}}</span>
</div></div>
<!-- Assigned To -->
<div class="form-group">
{{Form::label('assigned','Assigned To:',array('class'=>'col-sm-2 control-label'))}}
<div class="col-sm-10">
<select multiple="multiple" name="assigned[]" id="assignedto">
	<option>Not Assigned</option>
    @foreach($members as $member)
    
           	 <?php
             if(isset($assigned) and in_array($member->id,$assigned)){
				 
            	echo "<option selected value=\"".$member->id."\">".$member->firstname." ". $member->lastname."</option>";
			 }else{
            echo "<option value=\"".$member->id."\">".$member->firstname." ". $member->lastname."</option>";
			 }?>
         

    @endforeach
</select>

<span class='error'>{{$errors->first('assigned')}}</span>
</div></div>











