@extends('site.layouts.default')
<?php $sequence ='';?>

    @section('content')
    <h1>Wait List Members</h1>
    <p><a href="{{route('members.index')}}">Show Active Members</a></p>
     @can('manage_members')
		    <div class="pull-right">
        <a href="{{{ route('members.create') }}}" class="btn btn-small btn-info iframe">
            <span class="glyphicon glyphicon-plus-sign"></span> Add Member</a>
    </div>
        
    
	@endcan
    <table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>
    <thead>
    <th>Wait List #</th>
     @while(list($key,$field)=each($fields))
     
    <th>
    {{$key}}
    </th>
    @endwhile
       
    </thead>
    <tbody>
    @foreach($members as $member)
        <tr>
            <?php reset($fields);
			++$sequence;?> 
            <td class="col-md-2">{{$sequence}}</td>
            @while(list($key,$field)=each($fields))
            	
                <td class="col-md-2">
				<?php
					$name = $member->firstname ." " . $member->lastname;

                    switch ($key) {
						
					case 'Name':
						echo "<a href=\"".route('members.show', $member->id) ."\" 
						title =\"See ". $name."'s details\" >". $name."</a>";
						
						if($member->email != "")
						{
							echo "<a href=\"mailto:".$member->email."\" 
							title=\"Email ".$name."\" 
							target=\"_top\">  <span class=\"glyphicon glyphicon-envelope\">  </span>  </a>";
							
						}else{
							echo " ";
						}
					
					break;
                    
					
					case 'Plots':
						foreach ($member->plots as $plot)
						{
						echo "<a href=\"". route('plots.show',$plot->id). "\">".$plot->plotnumber .' / ' . $plot->subplot . "</a><br />";
						
						}
					
					break;
                    
                    case 'Edit':

                    ?>
                    

                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">

                            <li><a href="{{route('members.edit',$member->id)}}"><i class="glyphicon glyphicon-pencil"></i> Edit {{$member->firstname}}'s details</a></li>
                           <li><a data-href="{{route('members.destroy',$member->id)}}" data-toggle="modal" data-target="#confirm-delete" data-title = " {{$member->firstname}}" href="#"><i class="glyphicon glyphicon-trash"></i> Delete {{$member->firstname}}</a></li>
                        </ul>
                    </div>

                    <?php


                    break;

                    default:

                        echo $member->$field;
                        break;
                    };?>

                </td>
            @endwhile

            

        </tr>
    @endforeach
    
    </tbody>
    </table>
{{-- Scripts --}}
@include('partials/_modal')
@include('partials._scripts')
@stop
