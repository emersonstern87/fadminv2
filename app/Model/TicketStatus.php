<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class TicketStatus extends Model
{
	public $timestamps = false;
	
	public function tickets()
	{
        return $this->hasMany('App\Model\Ticket', 'ticket_status_id');
    }

    public static function getAll()
    {
        $data = Cache::get('gb-ticketStatus');
        if (empty($data)) {
            $data = parent::all();
            Cache::put('gb-ticketStatus', $data, 30 * 86400);
        }

        return $data;
    }
    
}
