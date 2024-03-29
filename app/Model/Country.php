<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Cache;

class Country extends Model
{
    public $timestamps = false;

    public function leads()
    {
        return $this->hasMany('App\Model\Lead', 'country_id');
    }

    public function customerBranch()
    {
        return $this->hasOne('App\Model\CustomerBranch', 'billing_country_id');
    }

    public function suppliers()
    {
        return $this->hasMany("App\Model\Supplier", 'country_id');
    }

    public static function getAll()
    {
        $data = Cache::get('gb-countries');
        if (empty($data)) {
            $data = parent::all();
            Cache::put('gb-countries', $data, 30 * 86400);
        }
        return $data;
    }

    public static function getCountry($id)
    {
        $country = self::getAll()->where('id', $id)->first();
        return $country->name;
    }
}
