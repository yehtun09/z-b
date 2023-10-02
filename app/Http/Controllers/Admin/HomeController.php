<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class HomeController
{
    public function index()
    {
        if (Auth::user()->roles[0]->title == "Admin" || Auth::user()->roles[0]->title == "Administrator") {
            $allservices = Invoice::with('customer_name', 'customerAssign', 'customerAssign.service_person')->whereNotNull('customer_assign')->whereNull('invoice_status');

            $allservices = $allservices->count();
        } else {
            $allservices = Invoice::with('customer_name', 'customerAssign', 'customerAssign.service_person')->whereHas('customerAssign', function ($query) {
                $query->whereHas('service_person', function ($query) {
                    $query->where('users.id', Auth::user()->id);
                });
            })->whereNull('invoice_status');

            $allservices = $allservices->count();
        }


        if (Auth::user()->roles[0]->title == "Admin" || Auth::user()->roles[0]->title == "Administrator") {
            $completed = Invoice::with('customer_name', 'customerAssign', 'customerAssign.service_person')->where('invoice_status', '2');

            $completed = $completed->count();
        } else {
            $completed = Invoice::with('customer_name', 'customerAssign', 'customerAssign.service_person')->whereHas('customerAssign', function ($query) {
                $query->whereHas('service_person', function ($query) {
                    $query->where('users.id', Auth::user()->id);
                });
            })->where('invoice_status', '2');

            $completed = $completed->count();
        }


        if (Auth::user()->roles[0]->title == "Admin" || Auth::user()->roles[0]->title == "Administrator") {
            $suspend = Invoice::with('customer_name', 'customerAssign', 'customerAssign.service_person')->where('invoice_status', '3');
            $suspend = $suspend->count();
        } else {
            $suspend = Invoice::with('customer_name', 'customerAssign', 'customerAssign.service_person')->whereHas('customerAssign', function ($query) {
                $query->whereHas('service_person', function ($query) {
                    $query->where('users.id', Auth::user()->id);
                });
            })->where('invoice_status', '3');
            $suspend = $suspend->count();
        }


        if (Auth::user()->roles[0]->title == "Admin" || Auth::user()->roles[0]->title == "Administrator") {
            $pending = Invoice::with('customer_name', 'customerAssign', 'customerAssign.service_person')->where('invoice_status', '1');
            $pending = $pending->count();
        } else {
            $pending = Invoice::with('customer_name', 'customerAssign', 'customerAssign.service_person')->whereHas('customerAssign', function ($query) {
                $query->whereHas('service_person', function ($query) {
                    $query->where('users.id', Auth::user()->id);
                });
            })->where('invoice_status', '1');
            $pending = $pending->count();
        }



        if (Auth::user()->roles[0]->title == "Admin" || Auth::user()->roles[0]->title == "Administrator") {
            $cancel = Invoice::with('customer_name', 'customerAssign', 'customerAssign.service_person')->where('invoice_status', '4');
            $cancel = $cancel->count();
        } else {
            $cancel = Invoice::with('customer_name', 'customerAssign', 'customerAssign.service_person')->whereHas('customerAssign', function ($query) {
                $query->whereHas('service_person', function ($query) {
                    $query->where('users.id', Auth::user()->id);
                });
            })->where('invoice_status', '4');
            $cancel = $cancel->count();
        }


        $products = DB::table('invoice_product')->select('invoice_product.*', 'invoices.customer_name_id', 'invoices.customer_assign')->join('invoices', 'id', 'invoice_product.invoice_id')->where('invoices.customer_assign', '<>', null)->orderByDesc('created_at')->limit(10)->get();
        // return $products;
        return view('home', compact('allservices', 'completed', 'suspend', 'pending', 'cancel', 'products'));
    }
}
