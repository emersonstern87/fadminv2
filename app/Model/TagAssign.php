<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class TagAssign extends Model
{
	public $timestamps = false;

    public function tag()
    {
        return $this->belongsTo('App\Model\Tag', 'tag_id');
    }
}
