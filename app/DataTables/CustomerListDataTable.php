<?php
namespace App\DataTables;
use App\Model\Customer;
use Auth;
use DB;
use Helpers;
use Session;
use Yajra\DataTables\Services\DataTable;
class CustomerListDataTable extends DataTable
{
    public function ajax()
    {
        $customers = $this->query();
        return datatables()
            ->of($customers)
            ->addColumn('name', function ($customers) {
                $id = "<a href='" . url("customer/edit/$customers->id")."'>".$customers->name."</a>";
                return $id.'<br><a href="'.url("customer/adminlogin/$customers->id").'"  target="_blank"><span class="badge theme-bg2 text-white f-12">' . __('Login as') . '</span></a>';
            })

            ->addColumn('created_at', function ($customers) {

                $startDate = timeZoneformatDate($customers->created_at);
                $startTime = timeZonegetTime($customers->created_at);
                return $startDate.'<br>'.$startTime;
            })

            ->addColumn('inactive', function ($customers) {
                if($customers->is_active == 1){
                    $status = '<div class="switch d-inline m-r-10">
                            <input class="status" type="checkbox" data-customer_id="'.$customers->id.'"  id="switch-'.$customers->id.'" checked="">
                            <label for="switch-'.$customers->id.'" class="cr"></label>
                        </div>';
                }else{
                    $status = '<div class="switch d-inline m-r-10">
                            <input class="status" type="checkbox" data-customer_id="'.$customers->id.'"  id="switch-'.$customers->id.'">
                            <label for="switch-'.$customers->id.'" class="cr"></label>
                        </div>';
                }
                return $status;
            })

            ->addColumn('address', function ($customers) {
                $address = '';
                if (!empty($customers->customerBranch)) {
                    $address = '<p>'.(!empty($customers->customerBranch->billing_street) ? $customers->customerBranch->billing_street:'').''.(!empty($customers->customerBranch->billing_city)?', '.$customers->customerBranch->billing_city:'').(!empty($customers->customerBranch->billing_state) ? ', '.$customers->customerBranch->billing_state:'').''.(!empty($customers->customerBranch->billing_zip_code) ?', '.$customers->customerBranch->billing_zip_code:'').''.(!empty($customers->customerBranch->billingCountry) ? ', '.$customers->customerBranch->billingCountry->name:'').'</p>';
                }
                return $address;
            })

            ->rawColumns(['name', 'created_at', 'inactive', 'address'])

            ->make(true);
    }
 
    public function query() {
        $customer = isset($_GET['customer']) ? $_GET['customer'] : null;
        $customers = Customer::select();
        if (!empty($customer) && $customer == "inactive") {
            $customers->where('is_active', 0);
        } else if (!empty($customer) && $customer == "total") {
            $customers;
        } else {
            $customers->where('is_active', 1);
        }
        return $this->applyScopes($customers);
    }
    
    public function html() {
        return $this->builder()
            
            ->addColumn(['data' => 'id', 'name' => 'id', "visible" => false])
            
            ->addColumn(['data' => 'name', 'name' => 'customers.name', 'title' => __('Name')])
            
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => __('Email')])
            
            ->addColumn(['data' => 'phone', 'name' => 'phone', 'title' => __('Phone')])

            ->addColumn(['data' => 'address', 'name' => 'address', 'title' => __('Address')])
            
            ->addColumn(['data' => 'inactive', 'name' => 'inactive', 'title' => __('Status'), 'orderable' => false])
            
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => __('Created At')])
           
            ->parameters([
            'pageLength' => $this->row_per_page,
            'language' => [
                    'url' => url('/resources/lang/'.config('app.locale').'.json'),
                ],
            'order' => [0, 'DESC']
            ]);
    }

    protected function getColumns()
    {
        return [
            'id',
            'created_at',
            'updated_at',
        ];
    }

    protected function filename()
    {
        return 'customers_' . time();
    }
}
