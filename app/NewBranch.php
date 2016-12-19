<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewBranch extends Model
{
    public $table = 'newbranches';

    public function oldbranch()
    {
    	return $this->hasOne(Branch::class,'branchnumber','branch_id');
    }
}
