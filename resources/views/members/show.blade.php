@extends('site.layouts.default')

@section('content')
<p><a href="{{route('members.index')}}">Return to Members List</a></p>


     

 <h1>  

    @if (Auth::user()->hasRole('admin'))
		
        
     @else
     
     {{$member->firstname ." " . $member->lastname}}
	@endif
    </h1>  
    <fieldset><legend>Contact Details</legend>
   
    <p><strong>Phone:</strong><blockquote>{{$member->phone}}</blockquote></p>
    <p><strong>Email:</strong><blockquote><a href="mailto:{{$member->email}}" title="Email {{$member->firstname ." " . $member->lastname}}">{{$member->userdetails->email}}</a></blockquote></p>
     @if (Auth::user()->hasRole('board'))
     <p><strong>Address:</strong><blockquote>{{$member->address}}</blockquote></p>
     
     @endif

    </fieldset>
    </fieldset>
    <fieldset><legend>Membership Details</legend>
    <blockquote>

    <p><strong>Member since:</strong>
    @if($member->membersince != '0000-00-00')
    {{date('F Y',strtotime($member->membersince))}}</p>
    @endif
    <p><strong>Member status:</strong> {{$member->status}}</p>
    @if(count($member->plots)>0)
    <p><strong>Plot Assignment:</strong>

   
    	
        	<a href ="{{route('plots.show',$member->plots[0]->id)}}" title="Check out this plot detail">{{$member->plots[0]->plotnumber}} - {{$member->plots[0]->subplot}}</a><br/>
        
            

   
    </p>
    </blockquote>
    </fieldset>
     <fieldset><legend>Service Hours this year</legend>
    <blockquote>
    <table class='table table-striped'>
    <thead>
    <tr>
    <th>Date</th>
    <th align="center">Hours</th>
    <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <?php $total =null;?>
        @foreach ($member->userdetails->currentYearHours as $hours)
        <tr>
        <td>{{date('d M Y',strtotime($hours->servicedate))}}</td>
        <td align="center">{{number_format($hours->hours,1)}}</td>
        <?php $total = $total + $hours->hours;?>
        <td>{{$hours->description}}</td>
        </tr>


        @endforeach
    </tbody>
    <tfoot>
    <tr>
      <td>Total to date</td>
      <td align="center">{{number_format($total,1)}}</td>
    </tr>
  </tfoot>
    </table>

    </blockquote>
    </fieldset>
@endif
    {{-- Scripts --}}
@include('partials._scripts')
@stop
