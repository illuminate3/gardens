@extends ('site.layouts.default')
@section('content')
@if(strpos($year,"-"))
<?php
$dateObj   = \DateTime::createFromFormat('Y-m', $year);

?>
<h1>{{$hours[0]->gardener->firstname}} {{$hours[0]->gardener->lastname}}'s {{$dateObj->format('F Y')}}  Hours</h1>
<p><a href="{{route('hours.show',$id)."?y=".substr($year,0,4)}}">See all {{$hours[0]->gardener->firstname}} {{$hours[0]->gardener->lastname}}'s {{substr($year,0,4)}} hours</a></p>
@else
<h1>{{$hours[0]->gardener->firstname}} {{$hours[0]->gardener->lastname}}'s {{$year}}  Hours</h1>
@endif

@if($hours[0]->user_id == Auth::id()  or Auth::user()->hasRole('admin'))

<div class="pull-right">
    <a href="{{{ URL::to('hours/create') }}}" class="btn btn-small btn-info iframe">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Hours</a>
</div>

@endif
<?php $totalHours = 0;?>

    <table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>
    <thead>
     @while(list($key,$field)=each($fields))
    <th>
    {{$key}}
    </th>
    @endwhile
       
    </thead>
    <tbody>
    @foreach($hours as $hour)

        <tr>
            <?php reset($fields);?>
            @while(list($key,$field)=each($fields))
                <td><?php


                    switch ($key) {
                    
					 case 'Date':
                        echo date('d M Y',strtotime($hour->$field));
                        //echo date('d M Y',$hour->$field);
                    break;
                    case 'Hours':

                        echo number_format($hour->$field,2);
                    break;
					
					case 'Details':
					 	echo $hour->$field;
					break;
 					case 'Edit':

                    ?>
                    @include('partials/_modal')

                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">

                            <li><a href="{{route('hours.edit',$hour->id)}}"><i class="glyphicon glyphicon-pencil"></i> Edit </a></li>
                            <li><a data-href="{{route('hours.destroy',$hour->id)}}" data-toggle="modal" data-target="#confirm-delete" data-title = " these hours" href="#"><i class="glyphicon glyphicon-trash"></i> Delete </a></li>
                        </ul>
                    </div>

                    <?php


                    break;

                    default:
                        echo date('h:i a',strtotime($hour->$field));
                        break;

                    };?>

                </td>
            @endwhile

	<?php $totalHours = $totalHours + $hour->hours;?>

        </tr>
    @endforeach
	<tfoot><td colspan="3">Total Hours</td>
    <td>{{number_format($totalHours,2)}}</td></tfoot>
    </tbody>
</table>
{{-- Scripts --}}
@include('partials._scripts')
@stop
