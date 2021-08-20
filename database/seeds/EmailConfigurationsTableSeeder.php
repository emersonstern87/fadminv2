<?php

use Illuminate\Database\Seeder;

class EmailConfigurationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('email_configurations')->delete();
        
        \DB::table('email_configurations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'protocol' => 'smtp',
                'encryption' => 'tls',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' => '587',
                'smtp_email' => 'stockpile.techvill@gmail.com',
                'smtp_username' => 'stockpile.techvill@gmail.com',
                'smtp_password' => 'xgldhlpedszmglvj',
                'from_address' => 'stockpile.techvill@gmail.com',
                'from_name' => 'stockpile.techvill@gmail.com',
                'status' => 1,
            ),
        ));
        
        
    }
}