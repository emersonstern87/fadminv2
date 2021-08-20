<?php

use Illuminate\Database\Seeder;

class UrlShortnerConfigTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('url_shortner_config')->delete();
        
        \DB::table('url_shortner_config')->insert(array (
            0 => 
            array (
                'id' => 3,
                'type' => 'Bitly',
                'status' => 'Active',
                'key' => '',
                'secretkey' => '6d326e4ad38524f846ec541933bf2f06729c1f74',
                'default' => 'Yes',
            ),
        ));
        
        
    }
}