<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Model\Customer', 'customer_id');
    }

    public function store($objectType = null, $objectId = null, $authType = null, $authId = null, $description = null, $options = []) 
    {
      	$id = '';
		if (empty($objectType) || empty($objectId) || empty($authType) || empty($authId) ||  empty($description) ) {
			return $id;
		}
		$data                     = new Activity();
		$data->object_id          = $objectId;
		$data->object_type        = $objectType;
		if ($authType == 'user') {
			$data->user_id = $authId;
		} else {
			$data->customer_id = $authId;
		}
		$data->description          = $description;
		if ($data->save()) {
			$id = $data->id;
		}

		return $id;
    }
}
