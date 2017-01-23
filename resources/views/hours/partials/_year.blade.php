<?php $years = ['2017','2016','2015','2014'];?>


<label>Show hours for </label>
       <select name='year' class="btn btn-mini" onchange='this.form.submit()'>
           @foreach ($years as $year)
           	@if(isset($showyear) && $showyear == $year))
           		<option selected value="{{$year}}">{{$year}}</option>
              @else  
                <option  value="{{$year}}">{{$year}}</option>

			@endif	
           @endforeach
        </select>
 
         <button type="submit"  class= "btn btn-default btn-xs"><span class="glyphicon glyphicon-search"></span> Search!</button>


		

