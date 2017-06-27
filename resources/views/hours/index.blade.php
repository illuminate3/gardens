@extends ('site.layouts.default')
@section('content')
<h1>Your Hours</h1>

<div class="pull-right">
    <a href="{{{ URL::to('hours/create') }}}" class="btn btn-small btn-info iframe">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Hours</a>
</div>
{{Form::open(array('route'=>'hours.index', 'method' => 'get','class'=>'form', 'id'=>'selectForm'))}}
@include('hours.partials._year')
{{Form::close()}}
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

                        echo $hour->$field;
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
                            <li><a data-href="/hours/{{$hour->id}}/delete" data-toggle="modal" data-target="#confirm-delete" data-title = " these hours" href="#"><i class="glyphicon glyphicon-trash"></i> Delete </a></li>
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
    <td>{{$totalHours}}</td></tfoot>
    </tbody>
</table>
{{-- Scripts --}}
@include('partials._scripts')
@stop
