<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class Plot extends \Eloquent {

	// Add your validation rules here
	public  $rules = [
		'plotnumber'=>'required',
		'type'=>'required',
		'width'=>'required',
		'length'=>'required',
		'row'=>'required',
		'col'=>'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['plotnumber','subplot','type','width','length','row','col','description'];

	
	public function managedBy()
    {
        return $this->belongsToMany(Member::class);
    }

}