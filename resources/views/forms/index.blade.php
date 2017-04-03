@extends('site.layouts.default')


    @section('content')
    <?php $fields = ['Submitted by'=>'submitter','Date'=>'date','Form'=>'form','Comments'=>'comments','Actions'=>'actions'];?>
	
	
    <h1>Form Responses</h1>

   
 
    
    <table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>
    <thead>
     @while(list($key,$field)=each($fields))
     
    <th>
    {{$key}}
    </th>
    @endwhile
       
    </thead>
    <tbody>
    @foreach($forms as $form)
        <tr>
        <td>
        	{{$form->name}}

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
            @include('partials/_modal')
<td>
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">

            
                         <li><a data-href="/forms/{{$form->id}}/delete" data-toggle="modal" data-target="#confirm-delete" data-title = " this response" href="#"><i class="glyphicon glyphicon-trash"></i> Delete this response</a></li>
                </ul>
            
</td>
        </tr>
    @endforeach
    
    </tbody>
    </table>
{{-- Scripts --}}
@include('partials._scripts')
@stop
