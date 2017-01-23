@extends ('site.layouts.default')
@section('content')


    <h1>Summary Service Hours</h1>
<a href = "{{route('sendsummaryemails')}}"><button class="btn btn-success">Send Summary Emails</button></a>
    <table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>
    <thead>
     @while(list($key,$field)=each($fields))
    <th>
    {{$field}}
    </th>
    @endwhile
       
    </thead>
    <tbody>
    @foreach($plotsummary as $plot)
    <?php $commitment =$plot['type']=='full' ?  24 :  12; ?>
        <tr class="{{$commitment > $plot['sum'] ? 'danger' : ''}}">
            <?php reset($fields);?>
            @while(list($key,$field)=each($fields))
                <td>
                    @if($field=='met commitment')
                    {{$commitment < $plot['sum'] ?  "<span style='color:green' class='glyphicon glyphicon-ok'></span>" : ''}}
                    @else
                    {{is_array($plot[$field]) ? implode("/", $plot[$field]) : $plot[$field]}}
                    @endif
                </td>
            @endwhile

            

        </tr>
    @endforeach
    
    </tbody>
    </table>
{{-- Scripts --}}
@include('partials._scripts')
@stop
