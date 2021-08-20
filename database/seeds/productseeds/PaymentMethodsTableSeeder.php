<?php

namespace Seeds\ProductSeeds;

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payment_methods')->delete();
        
        \DB::table('payment_methods')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Paypal',
                'mode' => 'sandbox',
                'client_id' => 'f7667406-1b6d-4b84-912a-9e9578d318fb',
                'consumer_key' => NULL,
                'consumer_secret' => '87853ffe-c240-47f0-abb6-29b10df4562e',
                'approve' => NULL,
                'is_default' => 0,
                'is_active' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Bank',
                'mode' => NULL,
                'client_id' => '1',
                'consumer_key' => NULL,
                'consumer_secret' => NULL,
                'approve' => 'manual',
                'is_default' => 1,
                'is_active' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Stripe',
                'mode' => NULL,
                'client_id' => NULL,
                'consumer_key' => '95f693a6-c448-4a4a-9a58-fec0152fae6d',
                'consumer_secret' => '21001b75-8e82-441c-8f7e-2a6b8fbe0109',
                'approve' => NULL,
                'is_default' => 0,
                'is_active' => 1,
            ),
        ));
        
        
    }
}