<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class LeadSource extends Model
{
	public $timestamps = false;

    public function leads()
    {
        return $this->hasMany('App\Model\Lead', 'lead_source_id');
    }
}
