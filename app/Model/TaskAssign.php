<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class TaskAssign extends Model
{
	public $timestamps = false;
    
    public function task()
    {
        return $this->belongsTo('App\Model\Task');
    }
}
