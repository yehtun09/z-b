<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Admin\InvoiceController;
use Gate;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\Admin\InvoiceResource;
use App\Http\Resources\InvoiceDetailResource;
use App\Models\CustomerAssign;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class InvoiceApiController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoices = Invoice::whereNotNull('customer_assign')
        ->whereNull('invoice_status')
        ->whereHas('customerAssign',function($query){
                $query->whereHas('service_person',function($query){
                    $query->where('users.id', Auth::user()->id);
                });
            })->get();
        return InvoiceResource::collection($invoices);
    }

    public function store(Request $request)
    {
        $loopcount = (count($request->all()) - 5) / 3;
        $total_qty = 0;
        $total_price = 0;
        for ($i = 0; $i < $loopcount; $i++) {
            $qty = 'qty' . $i;
            $total = 'unit_total' . $i;
            // dd($product_name);

            $total_qty += (int)$request->$qty;
            $total_price += (int)$request->$total;
        }
        $total_price = $total_price - $total_price * (int)$request->discount / 100 + $request->service_fees;
        $invoice = [
            'invoice_code' => $request->invoice_code,
            'customer_name_id' => $request->customer_name_id,
            'created_by_id' => Auth::user()->id,
            'total_qty' => $total_qty,
            'total' => $total_price
        ];

        $invoice_detail = Invoice::create($invoice);
        $invoice_product = [
            'invoice_id' => $invoice_detail->id,
            'service_fees' => $request->service_fees,
            'discount' => $request->discount
        ];

        for ($i = 0; $i < $loopcount; $i++) {
            $product_name = 'product_name_id' . $i;
            $qty = 'qty' . $i;
            $total = 'unit_total' . $i;
            // dd($product_name);
            $invoice_product['product_id'] = $request->$product_name;
            $invoice_product['qty'] = $request->$qty;
            $invoice_product['total'] = $request->$total;
            $stocks = Product::where('id', $request->$product_name)->first()->stock_qty;
            Product::find($request->$product_name)->update(['stock_qty' => $stocks - $request->$qty]);
            InvoiceProduct::create($invoice_product);
        }

        return response()->json($invoice_detail)
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return InvoiceDetailResource::collection(Invoice::where('id', $invoice->id)->get())[0];
    }

    public function update(Request $request, Invoice $invoice)
    {
        $invoice->update($request->all());
        $invoice->products()->sync($request->input('products', []));

        return response()->json([
            'message' => " $invoice->invoice_code was updated successfully! "
        ]);
    }

    public function destroy(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function updateQty($id, $pid, Request $request)
    {
        try {
            $invoice =  InvoiceProduct::where('invoice_id', $id)
                ->where('product_id', $pid)
                ->get();
            $product = Product::where('id', $pid)->first();
            $unit_total = $product->sales_price * $request->qty;
            $invoice = InvoiceProduct::where('invoice_id', $id)
                ->where('product_id', $pid)
                ->update([
                    'qty' => $request->qty,
                    'total' => $unit_total
                ]);

            $invoices = InvoiceProduct::where('invoice_id', $id)->get();
            $unit_totals = 0;
            $qty = 0;
            $discount = 0;
            foreach ($invoices as $i) {
                $qty += $i->qty;
                $unit_totals += $i->total;
            }
            $sub_total = $unit_totals + $invoices->first()->service_fees;
            $discount = $sub_total * $invoices->first()->discount / 100;
            $total = $sub_total - $discount;
            Invoice::where('id', $id)->update([
                'total_qty' => $qty,
                'total' => $total,
                'sub_total' => $sub_total
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

        return response()->json([
            "message" => 'success',
            'status' => 200
        ], 200);
    }
}
