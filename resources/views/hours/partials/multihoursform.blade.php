
<table>
<thead>
<th>Date</th>
<th>Hours</th>
<th>Description</th>
</thead>
<tbody>
@for ($i = 5; $i < 10; $i++)
<tr>
   <td class="input-group date" id="datetimepicker{{$i}}">
        <input id='servicedate[{{$i}}]' name='servicedate[{{$i}}]' type="text" class="form-control" value="{{ old('servicedate[$i]') }}" />
        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
        </span>
   </td>
   <td><input id ="hours[{{$i}}]" name ="hours[{{$i}}]" value="{{ old('hours[$i]') }}" /></td>
   <td><input id ="description[{{$i}}]" name ="description[{{$i}}]" value="{{ old('description[$i]') }}" /></td>
               
</tr>
@endfor
    <input type='hidden' name='user[]' value ='{{ auth()->user()->id}}' />
    </tbody>
    </table>




