<?php

namespace App\Exports;

use App\Model\Transaction;
use App\Model\Currency;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class bankStatementExport implements FromQuery, WithHeadings, WithMapping
{
    private $myAmount;
    private $totalCredit;
    private $totalDebit;
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $from  = isset($_GET['from']) ? DbDateFormat($_GET['from']) : null;
        $to   = isset($_GET['to']) ? DbDateFormat($_GET['to']) : null;
        $account_no = isset($_GET['account_no']) ? $_GET['account_no'] : null;
        $mode = isset($_GET['mode']) ?$_GET['mode']: null;
        $type = isset($_GET['type']) ?$_GET['type']: null;
        $bankStatements = Transaction::with('account')->orderBy('transaction_date', 'ASC');     
        $bankStatements = (new Transaction)->getTransactionByAccountId($from, $to, $account_no, $mode, $type)
                                    ->orderBy('transaction_date', 'desc')->orderBy('transaction_date', 'ASC');   

        $this->myAmount = DB::select("SELECT SUM(amount) as amount FROM transactions 
        WHERE transaction_date <'$from' 
        AND account_id = $account_no");

        return $bankStatements;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Type',
            'Description',
            'Cash out (Credit)',
            'Cash in (Debit)',
            'Balance',
        ];
    }

    public function map($bankStatement): array
    {
        $presentCurrency  = Currency::find($bankStatement->currency_id);
        $debit = 0;
        $credit = 0;
        if ($bankStatement->amount>0) {
            $this->myAmount[0]->amount = $this->myAmount[0]->amount+$bankStatement->amount;
            $debit = $bankStatement->amount;
            $this->totalDebit += $debit;
        }
        else {
            $this->myAmount[0]->amount = $this->myAmount[0]->amount+$bankStatement->amount;
            $credit = abs($bankStatement->amount);
            $this->totalCredit += $credit;
        }


        return [
            formatDate($bankStatement->transaction_date),
            ucwords(str_replace ('_',' ', strtolower($bankStatement->transaction_method))),
            $bankStatement->description,
            formatCurrencyAmount($credit, $presentCurrency->symbol),
            formatCurrencyAmount($debit, $presentCurrency->symbol),
            formatCurrencyAmount($this->myAmount[0]->amount, $presentCurrency->symbol)
        ];
    }
}