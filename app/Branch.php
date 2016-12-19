<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public $table='branches';
    public function matching()
    {
    	return $this->hasOne(NewBranch::class,'branch_id','branchnumber');

    }
}
