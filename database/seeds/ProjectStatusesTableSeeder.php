<?php

use Illuminate\Database\Seeder;

class ProjectStatusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('project_statuses')->delete();
        
        \DB::table('project_statuses')->insert(array (
            0 => 
            array (
                'id' => 4,
                'name' => 'Cancelled',
            ),
            1 => 
            array (
                'id' => 5,
                'name' => 'Finished',
            ),
            2 => 
            array (
                'id' => 2,
                'name' => 'In Progress',
            ),
            3 => 
            array (
                'id' => 1,
                'name' => 'Not Started',
            ),
            4 => 
            array (
                'id' => 3,
                'name' => 'On Hold',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Archive',
            ),
        ));
        
        
    }
}