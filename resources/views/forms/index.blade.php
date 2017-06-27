@extends('site.layouts.default')


    @section('content')
   	
	
    <h1>Form Responses</h1>

   
 
    
    <table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>
    <thead>
     <th>Submitted </th>
     <th>Date </th>
     <th>Form </th>
     <th>Comments </th>
     <th>Actions</th>
       
    </thead>
    <tbody>
    @foreach($forms as $form)
        <tr>
        <td>
        	<a href="{{route('forms.show',$form->id)}}">{{$form->name}}</a>

        </td>
        <td>
        	{{$form->created_at}}
        </td>
        <td>
        	
        	{{$form->form}}
        </td>
        <td>
        	
        	{{$form->comments}}
        </td>
           
<td>
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">

            
                         <li><a data-href="{{route('forms.destroy',$form->id)}}" data-toggle="modal" data-target="#confirm-delete" data-title = " this response" href="#"><i class="glyphicon glyphicon-trash"></i> Delete this response</a></li>
                </ul>
            
</td>
        </tr>
    @endforeach
    
    </tbody>
    </table>
{{-- Scripts --}}
@include('partials/_modal')
@include('partials._scripts')
@stop
