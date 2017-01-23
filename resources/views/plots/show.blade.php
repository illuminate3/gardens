@extends ('site.layouts.default')
@section('content')
<p><a href="{{route('plots.index')}}">Return to Plot Map</a></p>
<p><a href="{{route('plotlist')}}">Return to Plot List</a></p>
    <h1>
     @if (Auth::user()->hasRole('admin'))
		<a href="{{route('plots.edit',$plot->id)}}" 
        title="Edit this Plot Details">
        Plot Details</a>
        
     @else
     
     Plot Details
	@endif
    
    
    
    </h1>

<p><strong>Plot Number:</strong> {{$plot->plotnumber}} Sub Plot:{{$plot->subplot}}</p>



<p><strong>Dimensions (approx);</strong><br /> Width : {{number_format($plot->width,1)}}' Length: {{number_format($plot->length,1)}}' Area: {{number_format($plot->length * $plot->width,1)}} sq ft</p>

<p><strong>Description:</strong> {{$plot->description}}</p>

<p><strong>Type:</strong>{{$plot->type}}</p>

<p><strong>Managed By:</strong><br />
	@foreach ($plot->managedBy as $gardener)
		<a href="{{route('members.show',$gardener->id)}}">{{$gardener->firstname}} {{$gardener->lastname }}</a><br />
    @endforeach
</p>

{{-- Scripts --}}
@include('partials._scripts')
@stop