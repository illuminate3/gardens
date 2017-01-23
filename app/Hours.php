<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class Hours extends Model {

	// Add your validation rules here
	public  $rules = [
		'servicedate' => 'required|date',
		'starttime' =>'required_without_all:hours,endtime',
		'endtime'=>'required_without_all:hours,starttime',
		'hours'=>"required_without_all:starttime,endtime",
		'description'=>'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['servicedate','starttime','endtime','description','hours','user_id'];

	public function gardener()
    {
        return $this->belongsTo(Member::class,'user_id','user_id');
    }
	
		
	
	public function exportHours($fields,$hours){

		$output='';
		foreach ($fields as $field) {
			if(is_array($field)) {
					while(list($key,$value) =each($field)){
						$output.=$key.",";

					}
				 }else{
			 $output.=$field.",";
				 }
		}
		$output.="\n";
	  	foreach ($hours as $row) {
			//dd($row->gardener->firstname);
		  reset ($fields);
		  foreach ($fields as $field) {
			 if(is_array($field)) {
				while(list($key,$value) =each($field)){
						if(isset($row->$key->$value)){
						// remove non printing characters from string then remove any commas
						$string =$this->cleanseString($row->$key->$value);
						}
						$output.=$string.",";
				}
				
			 }else{
				if(!$row->$field) {
					$output.=",";
				}else{
					// remove non printing characters from string then remove any commas
					$string =$this->cleanseString($row->$field);
					$output.=$string.",";
				}
			 }

			  
		  }
		  $output.="\n";
			  
		}

	return $output;
	
		}
	
		private function cleanseString($string)
	{
		$string = preg_replace('/[\x00-\x1F\x80-\xFF]/', '',$string);
		$string = str_replace(","," ", $string);
	return $string;
	}
}