<?php

namespace Seeds\ProductSeeds;

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('transactions')->delete();
        
        \DB::table('transactions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'currency_id' => 3,
                'amount' => 90000.0,
                'transaction_type' => 'Cash-in',
                'account_id' => 1,
                'transaction_date' => '2020-04-13',
                'user_id' => 1,
                'transaction_reference_id' => 1,
                'transaction_method' => 'OPENING_BALANCE',
                'description' => 'opening balance',
                'payment_method_id' => 1,
                'params' => NULL,
                'created_at' => '2020-04-13 13:56:28',
            ),
            1 => 
            array (
                'id' => 2,
                'currency_id' => 4,
                'amount' => 50000.0,
                'transaction_type' => 'Cash-in',
                'account_id' => 2,
                'transaction_date' => '2020-04-13',
                'user_id' => 1,
                'transaction_reference_id' => 2,
                'transaction_method' => 'OPENING_BALANCE',
                'description' => 'opening balance',
                'payment_method_id' => 1,
                'params' => NULL,
                'created_at' => '2020-04-13 14:01:16',
            ),
            2 => 
            array (
                'id' => 3,
                'currency_id' => 2,
                'amount' => 60000.0,
                'transaction_type' => 'Cash-in',
                'account_id' => 3,
                'transaction_date' => '2020-04-13',
                'user_id' => 1,
                'transaction_reference_id' => 3,
                'transaction_method' => 'OPENING_BALANCE',
                'description' => 'opening balance',
                'payment_method_id' => 1,
                'params' => NULL,
                'created_at' => '2020-04-13 14:05:16',
            ),
            3 => 
            array (
                'id' => 4,
                'currency_id' => 1,
                'amount' => 600000.0,
                'transaction_type' => 'Cash-in',
                'account_id' => 4,
                'transaction_date' => '2020-04-13',
                'user_id' => 1,
                'transaction_reference_id' => 4,
                'transaction_method' => 'OPENING_BALANCE',
                'description' => 'opening balance',
                'payment_method_id' => 1,
                'params' => NULL,
                'created_at' => '2020-04-13 14:08:03',
            ),
            4 => 
            array (
                'id' => 5,
                'currency_id' => 3,
                'amount' => 2000.0,
                'transaction_type' => 'deposit',
                'account_id' => 1,
                'transaction_date' => '2020-03-17',
                'user_id' => 1,
                'transaction_reference_id' => 5,
                'transaction_method' => 'DEPOSIT',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:11:08',
            ),
            5 => 
            array (
                'id' => 6,
                'currency_id' => 3,
                'amount' => 3000.0,
                'transaction_type' => 'deposit',
                'account_id' => 1,
                'transaction_date' => '2020-03-21',
                'user_id' => 1,
                'transaction_reference_id' => 6,
                'transaction_method' => 'DEPOSIT',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:11:32',
            ),
            6 => 
            array (
                'id' => 7,
                'currency_id' => 4,
                'amount' => 3000.0,
                'transaction_type' => 'deposit',
                'account_id' => 2,
                'transaction_date' => '2020-04-01',
                'user_id' => 1,
                'transaction_reference_id' => 7,
                'transaction_method' => 'DEPOSIT',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 3,
                'params' => NULL,
                'created_at' => '2020-04-13 20:12:00',
            ),
            7 => 
            array (
                'id' => 8,
                'currency_id' => 4,
                'amount' => 6000.0,
                'transaction_type' => 'deposit',
                'account_id' => 2,
                'transaction_date' => '2020-04-05',
                'user_id' => 1,
                'transaction_reference_id' => 8,
                'transaction_method' => 'DEPOSIT',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:12:23',
            ),
            8 => 
            array (
                'id' => 9,
                'currency_id' => 2,
                'amount' => 5000.0,
                'transaction_type' => 'deposit',
                'account_id' => 3,
                'transaction_date' => '2020-02-12',
                'user_id' => 1,
                'transaction_reference_id' => 9,
                'transaction_method' => 'DEPOSIT',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 1,
                'params' => NULL,
                'created_at' => '2020-04-13 20:12:44',
            ),
            9 => 
            array (
                'id' => 10,
                'currency_id' => 2,
                'amount' => 2000.0,
                'transaction_type' => 'deposit',
                'account_id' => 3,
                'transaction_date' => '2020-03-20',
                'user_id' => 1,
                'transaction_reference_id' => 10,
                'transaction_method' => 'DEPOSIT',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:13:11',
            ),
            10 => 
            array (
                'id' => 11,
                'currency_id' => 1,
                'amount' => 7000.0,
                'transaction_type' => 'deposit',
                'account_id' => 4,
                'transaction_date' => '2020-04-11',
                'user_id' => 1,
                'transaction_reference_id' => 11,
                'transaction_method' => 'DEPOSIT',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:13:35',
            ),
            11 => 
            array (
                'id' => 12,
                'currency_id' => 1,
                'amount' => 8000.0,
                'transaction_type' => 'deposit',
                'account_id' => 4,
                'transaction_date' => '2020-04-12',
                'user_id' => 1,
                'transaction_reference_id' => 12,
                'transaction_method' => 'DEPOSIT',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 3,
                'params' => NULL,
                'created_at' => '2020-04-13 20:14:06',
            ),
            12 => 
            array (
                'id' => 13,
                'currency_id' => 3,
                'amount' => -5005.0,
                'transaction_type' => 'cash-out-by-transfer',
                'account_id' => 1,
                'transaction_date' => '2020-03-06',
                'user_id' => 1,
                'transaction_reference_id' => 13,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:14:36',
            ),
            13 => 
            array (
                'id' => 14,
                'currency_id' => 4,
                'amount' => 3250.0,
                'transaction_type' => 'cash-in-by-transfer',
                'account_id' => 2,
                'transaction_date' => '2020-03-06',
                'user_id' => 1,
                'transaction_reference_id' => 13,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:14:36',
            ),
            14 => 
            array (
                'id' => 15,
                'currency_id' => 3,
                'amount' => -6000.5,
                'transaction_type' => 'cash-out-by-transfer',
                'account_id' => 1,
                'transaction_date' => '2020-04-01',
                'user_id' => 1,
                'transaction_reference_id' => 14,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:15:12',
            ),
            15 => 
            array (
                'id' => 16,
                'currency_id' => 1,
                'amount' => 60.0,
                'transaction_type' => 'cash-in-by-transfer',
                'account_id' => 4,
                'transaction_date' => '2020-04-01',
                'user_id' => 1,
                'transaction_reference_id' => 14,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:15:12',
            ),
            16 => 
            array (
                'id' => 17,
                'currency_id' => 4,
                'amount' => -7008.0,
                'transaction_type' => 'cash-out-by-transfer',
                'account_id' => 2,
                'transaction_date' => '2020-04-05',
                'user_id' => 1,
                'transaction_reference_id' => 15,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:15:47',
            ),
            17 => 
            array (
                'id' => 18,
                'currency_id' => 2,
                'amount' => 8610.0,
                'transaction_type' => 'cash-in-by-transfer',
                'account_id' => 3,
                'transaction_date' => '2020-04-05',
                'user_id' => 1,
                'transaction_reference_id' => 15,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:15:47',
            ),
            18 => 
            array (
                'id' => 19,
                'currency_id' => 4,
                'amount' => -5301.5,
                'transaction_type' => 'cash-out-by-transfer',
                'account_id' => 2,
                'transaction_date' => '2020-04-07',
                'user_id' => 1,
                'transaction_reference_id' => 16,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:16:25',
            ),
            19 => 
            array (
                'id' => 20,
                'currency_id' => 3,
                'amount' => 7155.0,
                'transaction_type' => 'cash-in-by-transfer',
                'account_id' => 1,
                'transaction_date' => '2020-04-07',
                'user_id' => 1,
                'transaction_reference_id' => 16,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:16:25',
            ),
            20 => 
            array (
                'id' => 21,
                'currency_id' => 2,
                'amount' => -8003.0,
                'transaction_type' => 'cash-out-by-transfer',
                'account_id' => 3,
                'transaction_date' => '2020-04-13',
                'user_id' => 1,
                'transaction_reference_id' => 17,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:17:17',
            ),
            21 => 
            array (
                'id' => 22,
                'currency_id' => 3,
                'amount' => 24000.0,
                'transaction_type' => 'cash-in-by-transfer',
                'account_id' => 1,
                'transaction_date' => '2020-04-13',
                'user_id' => 1,
                'transaction_reference_id' => 17,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:17:17',
            ),
            22 => 
            array (
                'id' => 23,
                'currency_id' => 2,
                'amount' => -5600.0,
                'transaction_type' => 'cash-out-by-transfer',
                'account_id' => 3,
                'transaction_date' => '2020-04-13',
                'user_id' => 1,
                'transaction_reference_id' => 18,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:17:44',
            ),
            23 => 
            array (
                'id' => 24,
                'currency_id' => 1,
                'amount' => 532000.0,
                'transaction_type' => 'cash-in-by-transfer',
                'account_id' => 4,
                'transaction_date' => '2020-04-13',
                'user_id' => 1,
                'transaction_reference_id' => 18,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:17:44',
            ),
            24 => 
            array (
                'id' => 25,
                'currency_id' => 1,
                'amount' => -3000.0,
                'transaction_type' => 'cash-out-by-transfer',
                'account_id' => 4,
                'transaction_date' => '2020-03-20',
                'user_id' => 1,
                'transaction_reference_id' => 19,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:18:18',
            ),
            25 => 
            array (
                'id' => 26,
                'currency_id' => 3,
                'amount' => 255000.0,
                'transaction_type' => 'cash-in-by-transfer',
                'account_id' => 1,
                'transaction_date' => '2020-03-20',
                'user_id' => 1,
                'transaction_reference_id' => 19,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:18:18',
            ),
            26 => 
            array (
                'id' => 27,
                'currency_id' => 1,
                'amount' => -50013.0,
                'transaction_type' => 'cash-out-by-transfer',
                'account_id' => 4,
                'transaction_date' => '2020-03-27',
                'user_id' => 1,
                'transaction_reference_id' => 20,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:19:12',
            ),
            27 => 
            array (
                'id' => 28,
                'currency_id' => 2,
                'amount' => 4500.0,
                'transaction_type' => 'cash-in-by-transfer',
                'account_id' => 3,
                'transaction_date' => '2020-03-27',
                'user_id' => 1,
                'transaction_reference_id' => 20,
                'transaction_method' => 'TRANSFER',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-13 20:19:12',
            ),
            28 => 
            array (
                'id' => 29,
                'currency_id' => 3,
                'amount' => 10.0,
                'transaction_type' => 'cash-in-by-sale',
                'account_id' => NULL,
                'transaction_date' => '2020-04-15',
                'user_id' => 1,
                'transaction_reference_id' => 26,
                'transaction_method' => 'INVOICE_PAYMENT',
                'description' => 'Payment for INV-0001 ',
                'payment_method_id' => NULL,
                'params' => NULL,
                'created_at' => '2020-04-15 18:21:08',
            ),
            29 => 
            array (
                'id' => 30,
                'currency_id' => 1,
                'amount' => 2503.515,
                'transaction_type' => 'cash',
                'account_id' => 1,
                'transaction_date' => '2020-04-15',
                'user_id' => 1,
                'transaction_reference_id' => 27,
                'transaction_method' => 'POSINVOICE',
                'description' => '',
                'payment_method_id' => NULL,
                'params' => NULL,
                'created_at' => '2020-04-15 18:40:51',
            ),
            30 => 
            array (
                'id' => 31,
                'currency_id' => 3,
                'amount' => 50.0,
                'transaction_type' => 'cash-in-by-sale',
                'account_id' => NULL,
                'transaction_date' => '2020-04-15',
                'user_id' => 1,
                'transaction_reference_id' => 28,
                'transaction_method' => 'INVOICE_PAYMENT',
                'description' => 'Payment for INV-0001 ',
                'payment_method_id' => 1,
                'params' => NULL,
                'created_at' => '2020-04-15 19:05:33',
            ),
            31 => 
            array (
                'id' => 32,
                'currency_id' => 4,
                'amount' => 500.0,
                'transaction_type' => 'cash-in-by-sale',
                'account_id' => 2,
                'transaction_date' => '2020-04-15',
                'user_id' => 1,
                'transaction_reference_id' => 29,
                'transaction_method' => 'INVOICE_PAYMENT',
                'description' => 'Payment for INV-0010 ',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-15 19:08:32',
            ),
            32 => 
            array (
                'id' => 33,
                'currency_id' => 4,
                'amount' => 2210.71,
                'transaction_type' => 'cash-in-by-sale',
                'account_id' => 2,
                'transaction_date' => '2020-04-15',
                'user_id' => 1,
                'transaction_reference_id' => 30,
                'transaction_method' => 'INVOICE_PAYMENT',
                'description' => 'Payment for INV-0010 ',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-15 19:10:21',
            ),
            33 => 
            array (
                'id' => 34,
                'currency_id' => 4,
                'amount' => 1669.61,
                'transaction_type' => 'cash-in-by-sale',
                'account_id' => NULL,
                'transaction_date' => '2020-04-15',
                'user_id' => 1,
                'transaction_reference_id' => 31,
                'transaction_method' => 'INVOICE_PAYMENT',
                'description' => 'Payment for INV-0008 ',
                'payment_method_id' => 3,
                'params' => NULL,
                'created_at' => '2020-04-15 19:10:58',
            ),
            34 => 
            array (
                'id' => 35,
                'currency_id' => 4,
                'amount' => 3735.32,
                'transaction_type' => 'cash-in-by-sale',
                'account_id' => NULL,
                'transaction_date' => '2020-04-15',
                'user_id' => 1,
                'transaction_reference_id' => 32,
                'transaction_method' => 'INVOICE_PAYMENT',
                'description' => 'Payment for INV-0005 ',
                'payment_method_id' => NULL,
                'params' => NULL,
                'created_at' => '2020-04-15 19:11:43',
            ),
            35 => 
            array (
                'id' => 36,
                'currency_id' => 4,
                'amount' => 500.0,
                'transaction_type' => 'cash-in-by-sale',
                'account_id' => 2,
                'transaction_date' => '2020-04-15',
                'user_id' => 1,
                'transaction_reference_id' => 33,
                'transaction_method' => 'INVOICE_PAYMENT',
                'description' => 'Payment for INV-0009 ',
                'payment_method_id' => 2,
                'params' => NULL,
                'created_at' => '2020-04-15 19:12:59',
            ),
        ));
        
        
    }
}