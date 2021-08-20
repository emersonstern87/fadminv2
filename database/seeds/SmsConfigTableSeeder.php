<?php

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
                'key' => 'ACc65d48060cb670bd54bcbe31d1dc6e19',
                'secretkey' => '538f1df0c5bd4b502999724b8d7591cd',
                'default' => 'Yes',
                'default_number' => '13097600297',
            ),
        ));
        
        
    }
}