<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cache;

class EmailConfiguration extends Model
{
    public $timestamps = false;

    public static function getAll()
    {
        $data = Cache::get('gb-email_configurations');
        if (empty($data)) {
            $data = parent::all();
            Cache::put('gb-email_configurations', $data, 30 * 86400);
        }
        return $data;
    }
}
