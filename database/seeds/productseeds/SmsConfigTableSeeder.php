<?php

namespace Seeds\ProductSeeds;

use Illuminate\Database\Seeder;

class SmsConfigTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sms_config')->delete();
        
        \DB::table('sms_config')->insert(array (
            0 => 
            array (
                'id' => 1,
                'type' => 'twilio',
                'status' => 'Active',
                'key' => '1aaxcdff1a0a',
                'secretkey' => 'eWi2sO2asdfWZrkqfidfdsas7R',
                'default' => 'Yes',
                'default_number' => '880123456789',
            ),
        ));
        
        
    }
}