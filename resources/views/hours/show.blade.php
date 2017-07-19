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
    <a href="{{{ route('hours.create') }}}" class="btn btn-small btn-info iframe">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Hours</a>
</div>

@endif
<?php $totalHours = 0;?>

<table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>
    <thead>
        <th>Date</th>
        <th>From</th>
        <th>To</th>
        <th>Hours</th>
        <th>Details</th>
        @if(auth()->user()->hasRole('admin'))
            <th>Action</th>
        @endif
    </thead>

    <tbody>
        @foreach($hours as $hour)

            <tr>
            
            <td>{{$hour->starttime->format('d M Y')}}</td>
            <td>{{$hour->starttime->format('h:i a')}}</td>
             <td>{{$hour->endtime->format('h:i a')}}</td>
            <td>{{number_format($hour->hours,2)}}</td>
            <td>{{$hour->description}}</td>
            
            @if(auth()->user()->hasRole('admin'))
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
            @endif

            <?php $totalHours = $totalHours + $hour->hours;?>

            </tr>
        @endforeach
    </tbody>
<tfoot>
<td colspan="3">Total Hours</td>
<td>{{number_format($totalHours,2)}}</td>
</tfoot>

</table>
{{-- Scripts --}}
@include('partials/_modal')
@include('partials._scripts')
@stop
