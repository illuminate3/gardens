@extends ('site.layouts.default')
@section('content')
<h1>Your Hours</h1>

<div class="pull-right">
    <a href="{{{ route('hours.create') }}}" class="btn btn-small btn-info iframe">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Hours</a>
</div>
{{Form::open(array('route'=>'hours.index', 'method' => 'get','class'=>'form', 'id'=>'selectForm'))}}
@include('hours.partials._year')
{{Form::close()}}
<?php $totalHours = 0;?>

<table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>
    <thead>
        <th>Date</th>
        <th>From</th>
        <th>To</th>
        <th>Hours</th>
        <th>Details</th>
        <th>Edit</th>
    </thead>
    
    <tbody>
        @foreach($hours as $hour)
        
            <tr>

                <td>{{$hour->servicedate->format('d M Y')}}</td>
                <td>{{date('h:i a',strtotime($hour->starttime))}} </td>
                <td>{{date('h:i a',strtotime($hour->endtime))}}</td>
                <td>{{$hour->hours}}</td>
                <td>{{$hour->description}}</td>     
                <td>

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
                </td>
            <?php $totalHours = $totalHours + $hour->hours;?>
            </tr>
        @endforeach
    </tbody>

    <tfoot>
        <td colspan="3">Total Hours</td>
        <td>{{$totalHours}}</td>
    </tfoot>
    
</table>
{{-- Scripts --}}
@include('partials/_modal')
@include('partials._scripts')
@stop
