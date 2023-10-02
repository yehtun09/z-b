<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportInvoice implements FromView
{

    public function view(): View
    {
        return view('admin.exports.invoices', [
            'invoices' => Invoice::with('customer_name','customerAssign','products','service_person')->get(),
        ]);
    }
}
