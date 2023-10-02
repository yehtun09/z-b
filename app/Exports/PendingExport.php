<?php

namespace App\Exports;

use Exception;
use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class PendingExport implements FromView
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        if (Auth::user()->roles[0]->title == "Admin" || Auth::user()->roles[0]->title == "Administrator") {
            $invoices = Invoice::with('customer_name','customerAssign','customerAssign.service_person')->where('invoice_status', '1');
        } else {
            $invoices = Invoice::with('customer_name','customerAssign','customerAssign.service_person')->whereHas('customerAssign', function ($query) {
                    $query->whereHas('service_person', function ($query) {
                        $query->where('users.id', Auth::user()->id);
                    });
                })
                ->where('invoice_status', '1');
        }
        if($this->startDate){
            $invoices = $invoices->where('suspend_date','>=',date('Y-m-d',strtotime(str_replace('/','-',$this->startDate))));
        }
        if($this->endDate){
            $invoices = $invoices->where('suspend_date','<=',date('Y-m-d',strtotime(str_replace('/','-',$this->endDate))));
        }
        $invoices = $invoices->orderBy('assign_date','asc')->get();
        if(count($invoices)>0){
            return view('admin.exports.pending_export', [
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'invoices' => $invoices,
            ]);
        }
        else{
            throw new Exception('There is no data between '.$this->startDate.' and '.$this->endDate.'!');
        }
    }
}
