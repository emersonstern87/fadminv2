<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	
	public $timestamps = false;
    
    public function tagAssigns()
    {
        return $this->hasMany('App\Model\TagAssign', 'tag_id');
    }

}
