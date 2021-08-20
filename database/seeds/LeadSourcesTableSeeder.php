<?php

use Illuminate\Database\Seeder;

class LeadSourcesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('lead_sources')->delete();
        
        \DB::table('lead_sources')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Facebook',
                'status' => 'active',
            ),
        ));
        
        
    }
}