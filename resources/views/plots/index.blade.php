@extends ('site.layouts.default')
@section('content')


    <h1>All Plots</h1>
    <p><a href="{{route('plots.index')}}" >See Plot Map</a></p>
    <div class="pull-right">
        <a href="{{{ route('plots.create') }}}" class="btn btn-small btn-info iframe">
            <span class="glyphicon glyphicon-plus-sign"></span> Add Plot</a>
    </div>
    <table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>
    <thead>
     @while(list($key,$field)=each($fields))
    <th>
    {{$key}}
    </th>
    @endwhile
       
    </thead>
    <tbody>
    @foreach($plots as $plot)
        <tr>
            <?php reset($fields);?>
            @while(list($key,$field)=each($fields))
                <td><?php


                    switch ($key) {
                    case 'Width':
                        echo number_format($plot->$field,2);
                    break;

                    case 'Length':
                        echo number_format($plot->$field,2);
                        break;
                    case 'Area':
                        echo number_format(($plot->width * $plot->length),2);

                    break;
					
					case 'Assigned To':
						foreach($plot->managedBy as $gardener) 
						{
							echo "<a href=\"".route('members.show',$gardener->id)."\" >". $gardener->firstname ." ". $gardener->lastname."</a><br />";
							
						}
					
					
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

                            <li><a href="{{route('plots.edit',$plot->id)}}">
                            <i class="glyphicon glyphicon-pencil"></i> Edit plot</a></li>
                            <li><a data-href="{{route('plots.destroy',$plot->id)}}" data-toggle="modal" data-target="#confirm-delete" data-title = " this plot" href="#">
                            <i class="glyphicon glyphicon-trash"></i> Delete plot</a></li>
                        </ul>
                    </div>

                    <?php


                    break;

                    default:

                        echo $plot->$field;
                        break;
                    };?>

                </td>
            @endwhile

            

        </tr>
    @endforeach
    
    </tbody>
    </table>
{{-- Scripts --}}
@include('partials._scripts')
@stop
