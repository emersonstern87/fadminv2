<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Cache;

class Priority extends Model
{
	public $timestamps = false;

    public function tasks()
    {
        return $this->hasMany('App\Model\Task', 'priority');
    }

    public function tickets()
    {
        return $this->hasMany('App\Model\Ticket', 'priority_id');
    }

    public static function getAll()
    {
        $data = Cache::get('gb-priorities');
        if (empty($data)) {
            $data = parent::all();
            Cache::put('gb-priorities', $data, 30 * 86400);
        }
        return $data;
    }
}
