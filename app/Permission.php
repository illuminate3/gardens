<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Permission extends Model
{
    use Sluggable;
    public $fillable = ['name','slug','description'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


     public function roles()
    {
    	return $this->belongsToMany(Role::class);
    }
}
