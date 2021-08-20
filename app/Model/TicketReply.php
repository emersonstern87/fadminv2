<?php

namespace App\Model;

use App\Http\Start\Helpers;
use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;

class TicketReply extends Model
{
  	public function ticket()
	{
	    return $this->belongsTo('App\Model\Ticket','ticket_id');
	}

	public function user()
	{
	    return $this->belongsTo('App\Model\User','user_id');
	}

	public function customer()
	{
	    return $this->belongsTo('App\Model\Customer','customer_id');
	}
}
