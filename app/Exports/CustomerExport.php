<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Model\Customer;

class CustomerExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::orderBy('name')->get();
    }
}
