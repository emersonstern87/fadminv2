<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('items')->delete();
        
        \DB::table('items')->insert(array (
            0 => 
            array (
                'id' => 2,
                'stock_id' => 'IPHONE',
                'stock_category_id' => 1,
                'item_type' => 'product',
                'parent_id' => 0,
                'name' => 'iPhone 11 pro',
                'item_unit_id' => 1,
                'tax_type_id' => 1,
                'available_variant' => 'iPhone 11 pro - 5.8 " - Space Gray - 188',
                'size' => '5.8 "',
                'color' => 'Space Gray',
                'weight' => 188.0,
                'weight_unit_id' => 4,
                'is_stock_managed' => 1,
                'description' => NULL,
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => 0,
                'created_at' => '2020-04-08 12:56:04',
                'updated_at' => '2020-04-08 07:18:38',
            ),
            1 => 
            array (
                'id' => 3,
                'stock_id' => 'IPHONE 11',
                'stock_category_id' => 1,
                'item_type' => 'product',
                'parent_id' => 2,
                'name' => 'iPhone 11',
                'item_unit_id' => 1,
                'tax_type_id' => 1,
                'available_variant' => 'iPhone 11 - 5.8 " - silver - 188 - 2',
                'size' => '5.8 "',
                'color' => 'silver',
                'weight' => 188.0,
                'weight_unit_id' => 4,
                'is_stock_managed' => 1,
                'description' => NULL,
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => NULL,
                'created_at' => '2020-04-08 13:16:27',
                'updated_at' => '2020-04-08 07:18:53',
            ),
            2 => 
            array (
                'id' => 4,
                'stock_id' => 'SAMSUNG S10',
                'stock_category_id' => 1,
                'item_type' => 'product',
                'parent_id' => 0,
                'name' => 'Samsung Galaxy S10',
                'item_unit_id' => 1,
                'tax_type_id' => 1,
                'available_variant' => 'Samsung Galaxy S10 - 6.1" - Blue - 157',
                'size' => '6.1"',
                'color' => 'Blue',
                'weight' => 157.0,
                'weight_unit_id' => 4,
                'is_stock_managed' => 1,
                'description' => 'The phone comes with a 6.10-inch touchscreen display and an aspect ratio of 19:9. Samsung Galaxy S10 is powered by a 1.9GHz octa-core Samsung Exynos 9820 processor. It comes with 8GB of RAM.',
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => 0,
                'created_at' => '2020-04-08 13:27:10',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 5,
                'stock_id' => 'HUAWEI P30',
                'stock_category_id' => 1,
                'item_type' => 'product',
                'parent_id' => 0,
                'name' => 'Huawei P30 Pro',
                'item_unit_id' => 1,
                'tax_type_id' => 2,
                'available_variant' => NULL,
                'size' => NULL,
                'color' => NULL,
                'weight' => NULL,
                'weight_unit_id' => NULL,
                'is_stock_managed' => 1,
                'description' => '',
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => 0,
                'created_at' => '2020-04-08 13:31:51',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 6,
                'stock_id' => 'WATCH 4',
                'stock_category_id' => 1,
                'item_type' => 'product',
                'parent_id' => 0,
                'name' => 'Apple Watch Series 4',
                'item_unit_id' => 1,
                'tax_type_id' => 2,
                'available_variant' => NULL,
                'size' => NULL,
                'color' => NULL,
                'weight' => NULL,
                'weight_unit_id' => NULL,
                'is_stock_managed' => 1,
                'description' => '',
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => 0,
                'created_at' => '2020-04-08 13:55:37',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 7,
                'stock_id' => 'COFFEE MAKER',
                'stock_category_id' => 2,
                'item_type' => 'product',
                'parent_id' => 0,
                'name' => 'Coffee Maker',
                'item_unit_id' => 1,
                'tax_type_id' => 2,
                'available_variant' => NULL,
                'size' => NULL,
                'color' => NULL,
                'weight' => NULL,
                'weight_unit_id' => NULL,
                'is_stock_managed' => 1,
                'description' => NULL,
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => 0,
                'created_at' => '2020-04-08 16:30:31',
                'updated_at' => '2020-04-08 10:31:04',
            ),
            6 => 
            array (
                'id' => 8,
                'stock_id' => 'CLOCK',
                'stock_category_id' => 2,
                'item_type' => 'product',
                'parent_id' => 0,
                'name' => 'Havit Alarm Clock Wireless Speaker',
                'item_unit_id' => 1,
                'tax_type_id' => 1,
                'available_variant' => NULL,
                'size' => NULL,
                'color' => NULL,
                'weight' => NULL,
                'weight_unit_id' => NULL,
                'is_stock_managed' => 1,
                'description' => '',
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => 2,
                'created_at' => '2020-04-08 16:36:36',
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 9,
                'stock_id' => 'BLENDER',
                'stock_category_id' => 2,
                'item_type' => 'product',
                'parent_id' => 0,
                'name' => 'Blender',
                'item_unit_id' => 1,
                'tax_type_id' => 1,
                'available_variant' => NULL,
                'size' => NULL,
                'color' => NULL,
                'weight' => NULL,
                'weight_unit_id' => NULL,
                'is_stock_managed' => 1,
                'description' => NULL,
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => 0,
                'created_at' => '2020-04-08 16:46:50',
                'updated_at' => '2020-04-08 12:51:45',
            ),
            8 => 
            array (
                'id' => 10,
                'stock_id' => 'MANAGEMENT',
                'stock_category_id' => 2,
                'item_type' => 'service',
                'parent_id' => 0,
                'name' => 'Event Management',
                'item_unit_id' => 1,
                'tax_type_id' => 1,
                'available_variant' => NULL,
                'size' => NULL,
                'color' => NULL,
                'weight' => NULL,
                'weight_unit_id' => NULL,
                'is_stock_managed' => 0,
                'description' => NULL,
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => NULL,
                'created_at' => '2020-04-08 16:51:06',
                'updated_at' => '2020-04-08 10:52:31',
            ),
            9 => 
            array (
                'id' => 11,
                'stock_id' => 'PHOTOGRAPHY',
                'stock_category_id' => 2,
                'item_type' => 'service',
                'parent_id' => 0,
                'name' => 'Photography',
                'item_unit_id' => 1,
                'tax_type_id' => 1,
                'available_variant' => NULL,
                'size' => NULL,
                'color' => NULL,
                'weight' => NULL,
                'weight_unit_id' => NULL,
                'is_stock_managed' => 0,
                'description' => NULL,
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => NULL,
                'created_at' => '2020-04-08 16:54:03',
                'updated_at' => '2020-04-08 11:01:40',
            ),
            10 => 
            array (
                'id' => 12,
                'stock_id' => 'OATS',
                'stock_category_id' => 3,
                'item_type' => 'product',
                'parent_id' => 0,
                'name' => 'Oats',
                'item_unit_id' => 1,
                'tax_type_id' => 1,
                'available_variant' => NULL,
                'size' => NULL,
                'color' => NULL,
                'weight' => NULL,
                'weight_unit_id' => NULL,
                'is_stock_managed' => 1,
                'description' => '',
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => 0,
                'created_at' => '2020-04-08 16:56:58',
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 13,
                'stock_id' => 'CORN',
                'stock_category_id' => 3,
                'item_type' => 'product',
                'parent_id' => 0,
                'name' => 'Corn Flakes',
                'item_unit_id' => 1,
                'tax_type_id' => 1,
                'available_variant' => NULL,
                'size' => NULL,
                'color' => NULL,
                'weight' => NULL,
                'weight_unit_id' => NULL,
                'is_stock_managed' => 1,
                'description' => NULL,
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => 0,
                'created_at' => '2020-04-08 16:59:47',
                'updated_at' => '2020-04-08 11:02:47',
            ),
            12 => 
            array (
                'id' => 14,
                'stock_id' => 'MAC',
                'stock_category_id' => 1,
                'item_type' => 'product',
                'parent_id' => 0,
                'name' => 'Mac Book Pro',
                'item_unit_id' => 1,
                'tax_type_id' => 1,
                'available_variant' => 'Mac Book Pro - 13 " - Space Gray - 0.92',
                'size' => '13 "',
                'color' => 'Space Gray',
                'weight' => 0.92,
                'weight_unit_id' => 2,
                'is_stock_managed' => 1,
                'description' => '',
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => 0,
                'created_at' => '2020-04-08 17:11:12',
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 15,
                'stock_id' => 'MAC AIR',
                'stock_category_id' => 1,
                'item_type' => 'product',
                'parent_id' => 14,
                'name' => 'MacBook Air',
                'item_unit_id' => 1,
                'tax_type_id' => 1,
                'available_variant' => 'MacBook Air - 13 " - gold - 1.25 - 2',
                'size' => '13 "',
                'color' => 'gold',
                'weight' => 1.25,
                'weight_unit_id' => 2,
                'is_stock_managed' => 1,
                'description' => '',
                'hsn' => NULL,
                'is_active' => 1,
                'alert_quantity' => NULL,
                'created_at' => '2020-04-08 17:14:06',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}