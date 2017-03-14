@extends('site.layouts.default')


    @section('content')
    <?php $fields = ['First Name'=>'firstname','Last Name'=>'lastname','Phone'=>'phone','Plots'=>'plots','Type'=>'type','Roles'=>'role'];?>
	@can('manage_members')
		
			<?php $fields['Edit'] ='action';
			$fields['Status']='status';?>
	@endcan	
	
    <h1>Active Members</h1>
    <p><a href="{{route('members.waitlist')}}">Show Wait List Members</a></p>
    @can('manage_members')
		    <div class="pull-right">
        <a href="{{{ route('members.create') }}}" class="btn btn-small btn-info iframe">
            <span class="glyphicon glyphicon-plus-sign"></span> Add Member</a>
    </div>
        
    
	@endcan
 
    <a href="{{route('members.export')}}" title ="Export members list to Excel">Export members list to Excel</a>
    <table id ='sorttable' class='table table-striped table-bordered table-condensed table-hover'>
    <thead>
     @while(list($key,$field)=each($fields))
     
    <th>
    {{$key}}
    </th>
    @endwhile
       
    </thead>
    <tbody>
    @foreach($members as $member)
        <tr>

            <?php reset($fields);?>
            @while(list($key,$field)=each($fields))
                <td class="col-md-2">
				<?php
					$name = $member->firstname .' ' . $member->lastname;

                    switch ($key) {
						
					case 'First Name':
						echo "<a href=\"".route('members.show', $member->id) ."\" 
						title =\"See ". $name."'s details\" >". $member->firstname."</a>";
						
						if($member->email != "")
						{
							echo " <a href=\"mailto:".$member->email."\" 
							title=\"Email ".$name."\" 
							target=\"_top\"><span class=\"glyphicon glyphicon-envelope\">  </span>  </a>";
							
						}else{
							echo " ";
						}
					
					break;
					case 'Roles':
						
						if(isset($member->userdetails->roles) && count($member->userdetails->roles)>0){
							
							foreach ($member->userdetails->roles as $role){
								echo $role->name ."<br />";
							}	
						}

					break;
					case 'Type':
						if(isset($member->plots)) {
							foreach ($member->plots as $plot)
							{
								echo $plot->type;
							}
						}
					break;
					
					case 'Last Name':
						echo "<a href=\"".route('members.show', $member->id) ."\" 
						title =\"See ". $name."'s details\" >". $member->lastname."</a>";
						
						if($member->email != "")
						{
							echo " <a href=\"mailto:".$member->email."\" 
							title=\"Email ".$name."\" 
							target=\"_top\"><span class=\"glyphicon glyphicon-envelope\">  </span>  </a>";
							
						}else{
							echo " ";
						}
					
					break;
                    
					
					case 'Plots':
						if(isset($member->plots)) {
							foreach ($member->plots as $plot)
							{
								
							echo "<a href=\"". route('plots.show',$plot->id). "\"
							title ='Check out the details of this plot'>".$plot->plotnumber .' / ' . $plot->subplot . "</a><br />";
							
							}
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

                            <li><a href="{{route('members.edit',$member->id)}}"><i class="glyphicon glyphicon-pencil"></i> Edit {{$member->firstname}}'s details</a></li>
                                 <li><a data-href="/members/{{$member->id}}/delete" data-toggle="modal" data-target="#confirm-delete" data-title = " {{$member->firstname}}" href="#"><i class="glyphicon glyphicon-trash"></i> Delete {{$member->firstname}}</a></li>
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
@include('partials._scripts')
@stop
