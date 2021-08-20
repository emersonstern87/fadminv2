<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('languages')->delete();
        
        \DB::table('languages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'English',
                'short_name' => 'en',
                'flag' => 'en.jpg',
                'status' => 'Active',
                'is_default' => 1,
                'is_deletable' => 0,
                'direction' => 'ltr',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'عربى',
                'short_name' => 'ar',
                'flag' => 'ar.png',
                'status' => 'Active',
                'is_default' => 0,
                'is_deletable' => 0,
                'direction' => 'rtl',
            ),
        ));
        
        
    }
}