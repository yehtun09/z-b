<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Township;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Exports\ExportInvoice;
use App\Models\InvoiceProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyInvoiceRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Imports\InvoicesImport;

class InvoiceController extends Controller
{
    use MediaUploadingTrait;
    // public function index()
    // {
    //     abort_if(Gate::denies('invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $invoices = Invoice::whereNull('customer_assign')->latest()->paginate(10);
    //     $invoice_products = InvoiceProduct::get();
    //     $services = User::whereHas('roles', function ($query) {
    //         $query->where('roles.title', 'LIKE', '%Engineer%');
    //     })->get();
    //     return view('admin.invoices.index', compact('invoices', 'invoice_products', 'services'));
    // }

    public function index()
    {

        abort_if(Gate::denies('invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_id = auth()->user()->id;
        $user_role = auth()->user()->roles()->first()->title;
        if ($user_role === 'Engineer') {
            $invoices = Invoice::where('user_id', $user_id)->with('customer_name', 'customerAssign', 'products', 'service_person', 'media')->orderBy('assign_date', 'asc')->get();
        } else {
            $invoices = Invoice::with('customer_name', 'customerAssign', 'products', 'service_person', 'media')->orderBy('assign_date', 'asc')->get();
        }

        $services = User::whereHas('roles', function ($query) {
            $query->where('roles.title', 'LIKE', '%Engineer%');
        })->orderBy('created_at', 'asc')->get();

        $townships = Township::get();
        // return $invoices;
        return view('admin.invoices.index', compact('invoices', 'services', 'townships'));
    }

    public function create()
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customer_names = Customer::select('name', 'id', 'customer_code')->get();

        $product_names = Product::whereNull('parent_id')->pluck('product_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $drum_no = Product::select('drum_no')->distinct()->get();

        $users = User::get();

        return view('admin.invoices.create', compact('customer_names', 'product_names', 'users', 'drum_no'));
    }

    public function __store(Request $request)
    {


        $validatedData = $request->validate([
            'customer_name_id' => 'required',
            'issue_date' => 'required',
            'user_id' => 'required',
        ]);
        // dd($request->all());
        $request['total_amount'] = $request->total;
        $invoice = Invoice::create([
            'odb_no' => $request->odb_no,
            'odb_lat' => $request->odb_lat,
            'odb_long' => $request->odb_long,
            'odb_splitter_no' => $request->odb_splitter_no,
            'odb_splitter_pair_no' => $request->odb_splitter_pair_no,
            'ont_received_power' => $request->ont_received_power,
            'olt_name' => $request->olt_name,
            'assign_date' => $request->assign_date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'suspend_date' => $request->suspend_date,
            'finished_date' => $request->finished_date,
            'user_id' => $request->user_id,
            'installation_period' => $request->installation_period,
            'resolution' => $request->resolution,
            'start_meter' => $request->start_meter ?? 0,
            'end_meter' => $request->end_meter ?? 0,
            'drop_cable_length' => $request->drop_cable_length ?? 0,
            'cable_drum_no' => $request->cable_drum_no ?? 0,
            'drop_sleeve_pcs' => $request->drop_sleeve_pcs ?? 0,
            'core_jc_sleeve_holder_pcs' => $request->core_jc_sleeve_holder_pcs ?? 0,
            'patch_cord' => $request->patch_cord,
            'cable_tiles_pcs' => $request->cable_tiles_pcs,
            'label_tape_rol' => $request->label_tape_rol,
            'onu_sticker' => $request->onu_sticker,
            'customer_acceptance_form' => $request->customer_acceptance_form,
            'issue_date' => $request->issue_date,
            'customer_name_id' => $request->customer_name_id,
            'created_at' => $request->created_at,
            'customer_assign' => $request->customer_assign,
            'invoice_status' => $request->invoice_status,
            'total_qty' => $request->total_qty,
            'sub_total' => $request->sub_total,
            'total' => $request->total,
            'total_amount' => $request->total_amount,
            'received_total_amount' => $request->received_total_amount,
            'received_date' => $request->received_date,
            'remark' => $request->remark,
            'sale_person_remark' => $request->sale_person_remark,
            'installation_remark' => $request->installation_remark,
        ]);


        //odb update
        if ($request->input('odb', false)) {
            foreach ($request->input('odb', []) as $file) {
                $invoice->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('odb');
            }
        }

        //onu update
        if ($request->input('onu', false)) {
            $invoice->addMedia(storage_path('tmp/uploads/' . basename($request->input('onu'))))->toMediaCollection('onu');
        }

        //ssr update
        if ($request->input('ssr', false)) {
            $invoice->addMedia(storage_path('tmp/uploads/' . basename($request->input('ssr'))))->toMediaCollection('ssr');
        }

        $data = [];

        if ($request->product_name_id[0]) {
            for ($i = 0; $i < count($request->product_name_id); $i++) {
                $data[$request->product_name_id[$i]] = [
                    'qty' => $request->qty[$i],
                    'total' => $request->unit_total[$i],
                    'service_fees' => 0,
                    'discount' => 0,
                ];

                // Get the original Product model instance
                $originalProduct = Product::find($request->product_name_id[$i]);
                $originalProduct->total_stock_qty = $originalProduct->total_stock_qty - $request->qty[$i];
                if ($request->drop_cable_length) {
                    $originalProduct->total_length = $originalProduct->total_length - $request->drop_cable_length;
                }
                $originalProduct->save();
            }

            $invoice->products()->sync($data);
        }

        return redirect()->route('admin.invoices.index');
    }
    public function store(Request $request)
    {

        // return $request->all();
        $validatedData = $request->validate([
            'customer_name_id' => 'required',
            'issue_date' => 'required',
            'user_id' => 'required',
        ]);

        if ($validatedData) {
            $request['total_amount'] = $request->total;
            $invoice = Invoice::create([
                'odb_no' => $request->odb_no,
                'odb_lat' => $request->odb_lat,
                'odb_long' => $request->odb_long,
                'odb_splitter_no' => $request->odb_splitter_no,
                'odb_splitter_pair_no' => $request->odb_splitter_pair_no,
                'ont_received_power' => $request->ont_received_power,
                'olt_name' => $request->olt_name,
                'assign_date' => $request->assign_date,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'suspend_date' => $request->suspend_date,
                'finished_date' => $request->finished_date,
                'user_id' => $request->user_id,
                'installation_period' => $request->installation_period,
                'resolution' => $request->resolution,
                'start_meter' => $request->start_meter ?? 0,
                'end_meter' => $request->end_meter ?? 0,
                'drop_cable_length' => $request->drop_cable_length ?? 0,
                'cable_drum_no' => $request->cable_drum_no ?? 0,
                'drop_sleeve_pcs' => $request->drop_sleeve_pcs ?? 0,
                'core_jc_sleeve_holder_pcs' => $request->core_jc_sleeve_holder_pcs ?? 0,
                'patch_cord' => $request->patch_cord,
                'cable_tiles_pcs' => $request->cable_tiles_pcs,
                'label_tape_rol' => $request->label_tape_rol,
                'onu_sticker' => $request->onu_sticker,
                'customer_acceptance_form' => $request->customer_acceptance_form,
                'issue_date' => $request->issue_date,
                'customer_name_id' => $request->customer_name_id,
                // 'created_at' => $request->created_at,
                'customer_assign' => $request->customer_assign,
                'invoice_status' => $request->invoice_status,
                'total_qty' => $request->total_qty,
                'sub_total' => $request->sub_total,
                'total' => $request->total,
                'total_amount' => $request->total_amount,
                'received_total_amount' => $request->received_total_amount,
                'received_date' => $request->received_date,
                'remark' => $request->remark,
                'sale_person_remark' => $request->sale_person_remark,
                'installation_remark' => $request->installation_remark,
            ]);


            //odb update
            if ($request->input('odb', false)) {
                foreach ($request->input('odb', []) as $file) {
                    $invoice->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('odb');
                }
            }

            //onu update
            if ($request->input('onu', false)) {
                $invoice->addMedia(storage_path('tmp/uploads/' . basename($request->input('onu'))))->toMediaCollection('onu');
            }

            //ssr update
            if ($request->input('ssr', false)) {
                $invoice->addMedia(storage_path('tmp/uploads/' . basename($request->input('ssr'))))->toMediaCollection('ssr');
            }

            $data = [];

            if ($request->product_name_id[0]) {
                for ($i = 0; $i < count($request->product_name_id); $i++) {
                    $data[$request->product_name_id[$i]] = [
                        'qty' => $request->qty[$i],
                        'total' => $request->unit_total[$i],
                        'service_fees' => 0,
                        'discount' => 0,
                    ];



                    $originalProduct = Product::find($request->product_name_id[$i]);
                    $originalProduct->total_stock_qty = $originalProduct->total_stock_qty - $request->qty[$i];
                    // if ($request->drop_cable_length) {
                    //     $originalProduct->total_length = $originalProduct->total_length - $request->drop_cable_length;
                    // }
                    $originalProduct->save();
                }

                // $invoice->products()->sync($data);
                $invoice->products()->attach($data, ['created_at' => now()]);
            }
            if ($request->cable_drum_no) {
                $products = Product::where('drum_no', $request->cable_drum_no)->first();
                $products_length = $products->total_length - $request->drop_cable_length;
                $products->update(['total_length' => $products_length]);
            }


            return redirect()->route('admin.invoices.index');
        }
    }

    public function edit(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice->load('customer_name', 'created_by', 'products');
        $customer = $invoice->customer_name;
        $product_names = Product::whereNull('parent_id')->pluck('product_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $customer_names = Customer::select('name', 'id', 'customer_code')->get();
        $drum_no = Product::select('drum_no')->distinct()->get();
        $users = User::get();
        return view('admin.invoices.edit', compact('customer', 'invoice', 'product_names', 'customer_names', 'users', 'drum_no'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        // return "Fail";

        $invoice->update([
            'created_by_id' => auth()->id(),
        ]);
        if ($request->edit == '1') {
            $invoice->update([
                'total_qty' => $request->total_qty,
                'total' => $request->total ?? 0,
                'sub_total' => $request->sub_total
            ]);
            if ($request->old_id == $request->new_id) {
                $old_qty = InvoiceProduct::where('invoice_id', $request->invoice_id)
                    ->where('product_id', $request->old_id)
                    ->first()
                    ->qty;
                $stocks = Product::where('id', $request->new_id)->first()->total_stock_qty;
                if ($old_qty < $request->qty) {
                    Product::where('id', $request->new_id)->update(['total_stock_qty' => $stocks - ($request->qty - $old_qty)]);
                } else {
                    Product::where('id', $request->new_id)->update(['total_stock_qty' => $stocks + ($old_qty - $request->qty)]);
                }
            } else {
                $stocks = Product::where('id', $request->new_id)->first()->total_stock_qty;
                Product::where('id', $request->new_id)->update(['total_stock_qty' => $stocks - $request->qty]);
            }
            // $invoice->products()->sync($request->input('products', []));
            InvoiceProduct::where('invoice_id', $request->invoice_id)
                ->where('product_id', $request->old_id)
                ->update([
                    'product_id' => $request->new_id,
                    'qty' => $request->qty,
                    'total' => $request->line_total
                ]);
            return 'Invoice Updated Successfully!';
        } elseif ($request->edit == '2') {
            $total_qty = Invoice::where('id', $request->invoice_id)->first()->total_qty;
            $total_qty += (int) $request->qty;
            Invoice::where('id', $request->invoice_id)
                ->update([
                    'sub_total' => $request->sub_total,
                    'total' => $request->total ?? 0,
                    'total_qty' => $total_qty
                ]);
            InvoiceProduct::create([
                'invoice_id' => $request->invoice_id,
                'product_id' => $request->product_id,
                'qty' => $request->qty,
                'service_fees' => $request->service_fees ?? 0,
                'discount' => $request->discount ?? 0,
                'total' => $request->line_total ?? 0
            ]);
            $stocks = Product::where('id', $request->product_id)->first()->total_stock_qty;
            Product::where('id', $request->product_id)->update(['total_stock_qty' => $stocks - $request->qty]);
            return 'Invoice Updated Successfully!';
        }

        Invoice::where('id', $invoice->id)->update([
            "customer_name_id" => $request->customer_name_id,
            "odb_lat" => $request->odb_lat,
            "odb_long" => $request->odb_long,
            "odb_no" => $request->odb_no,
            "odb_splitter_no" => $request->odb_splitter_no,
            "odb_splitter_pair_no" => $request->odb_splitter_pair_no,
            "ont_received_power" => $request->ont_received_power,
            "olt_name" => $request->olt_name,
            // "assign_team" =>  $request->assign_team,
            'user_id' => $request->user_id,
            "installation_period" => $request->installation_period,
            "resolution" => $request->resolution,
            "cable_drum_no" => $request->cable_drum_no,
            "start_meter" => $request->start_meter ?? 0,
            "end_meter" => $request->end_meter ?? 0,
            "drop_cable_length" => $request->drop_cable_length ?? 0,
            "drop_sleeve_pcs" => $request->drop_sleeve_pcs,
            "core_jc_sleeve_holder_pcs" => $request->core_jc_sleeve_holder_pcs,
            "patch_cord" => $request->patch_cord,
            "cable_tiles_pcs" => $request->cable_tiles_pcs,
            "label_tape_rol" => $request->label_tape_rol,
            "onu_sticker" => $request->onu_sticker,
            "customer_acceptance_form" => $request->customer_acceptance_form,
            "update_status" => $request->update_status,
            "sale_person_remark" => $request->sale_person_remark,
            "installation_remark" => $request->installation_remark,
            "issue_date" => $request->issue_date,
            "assign_date" => $request->assign_date,
            "suspend_date" => $request->suspend_date,
            "finished_date" => $request->finished_date,
            "received_date" => $request->received_date,
            "total_qty" => $request->total_qty,
            "total" => $request->total,
            "total_amount" => $request->total,
            "received_total_amount" => $request->received_total_amount,
        ]);

        //odb update
        if (count($invoice->odb) > 0) {
            foreach ($invoice->odb as $media) {
                if (!in_array($media->file_name, $request->input('odb', []))) {
                    $media->delete();
                }
            }
        }
        $media = $invoice->odb->pluck('file_name')->toArray();
        foreach ($request->input('odb', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $invoice->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('odb');
            }
        }

        //onu update
        if ($request->input('onu', false)) {
            if (!$invoice->onu || $request->input('onu') !== $invoice->onu->file_name) {
                if ($invoice->onu) {
                    $invoice->onu->delete();
                }
                $invoice->addMedia(storage_path('tmp/uploads/' . basename($request->input('onu'))))->toMediaCollection('onu');
            }
        } elseif ($invoice->onu) {
            $invoice->onu->delete();
        }

        //ssr update
        if ($request->input('ssr', false)) {
            if (!$invoice->ssr || $request->input('ssr') !== $invoice->ssr->file_name) {
                if ($invoice->ssr) {
                    $invoice->ssr->delete();
                }
                $invoice->addMedia(storage_path('tmp/uploads/' . basename($request->input('ssr'))))->toMediaCollection('ssr');
            }
        } elseif ($invoice->ssr) {
            $invoice->ssr->delete();
        }


        //For Cable Drum Number
        if ($request->cable_drum_no) {
            if ($request->old_drum_no == $request->cable_drum_no) {
                $products = Product::where('drum_no', $request->cable_drum_no)->first();

                if ($request->old_length == $request->drop_cable_length) {
                    // $products->update(['total_length' => $request->drop_cable_length]);

                } elseif ($request->old_length > $request->drop_cable_length) {
                    $update_length = $request->old_length - $request->drop_cable_length;
                    $products_length = $products->total_length + $update_length;
                    $products->update(['total_length' => $products_length]);
                } else {
                    $update_length = $request->drop_cable_length - $request->old_length;
                    $products_length = $products->total_length - $update_length;
                    $products->update(['total_length' => $products_length]);
                }
            } else {
                if ($request->old_drum_no) {
                    $old_products = Product::where('drum_no', $request->old_drum_no)->first();
                    $old_products_length = $old_products->total_length + $request->old_length;
                    $old_products->update(['total_length' => $old_products_length]);
                }

                $new_products = Product::where('drum_no', $request->cable_drum_no)->first();
                $products_length = $new_products->total_length - $request->drop_cable_length;
                $new_products->update(['total_length' => $products_length]);
            }
        } elseif ($request->old_drum_no) {
                $old_products = Product::where('drum_no', $request->old_drum_no)->first();
                $old_products_length = $old_products->total_length + $request->old_length;
                $old_products->update(['total_length' => $old_products_length]);
        }
        //odp1 update
        // if($request->hasFile('odp1')){
        //     $invoice->addMediaFromRequest('odp1')->toMediaCollection('odp1');
        //     if ($invoice->getFirstMedia('odp1')) {
        //         $invoice->getFirstMedia('odp1')->delete();
        //     }
        // }

        // //odp2 update
        // if($request->hasFile('odp2')){
        //     $invoice->addMediaFromRequest('odp2')->toMediaCollection('odp2');
        //     if ($invoice->getFirstMedia('odp2')) {
        //         $invoice->getFirstMedia('odp2')->delete();
        //     }
        // }

        // //odp3 update
        // if($request->hasFile('odp3')){
        //     $invoice->addMediaFromRequest('odp3')->toMediaCollection('odp3');
        //     if ($invoice->getFirstMedia('odp3')) {
        //         $invoice->getFirstMedia('odp3')->delete();
        //     }
        // }

        // //onu update
        // if($request->hasFile('onu')){
        //     $invoice->addMediaFromRequest('onu')->toMediaCollection('onu');
        //     if ($invoice->getFirstMedia('onu')) {
        //         $invoice->getFirstMedia('onu')->delete();
        //     }
        // }

        // //ssr update
        // if($request->hasFile('ssr')){
        //     $invoice->addMediaFromRequest('ssr')->toMediaCollection('ssr');
        //     if ($invoice->getFirstMedia('ssr')) {
        //         $invoice->getFirstMedia('ssr')->delete();
        //     }
        // }

        if (isset($request->url)) {
            return redirect()->route($request->url);
        }
        return redirect()->route('admin.customer-assigns.index');
    }

    public function show(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice->load('customer_name', 'created_by', 'products');
        if (request()->ajax()) {
            return response()->json([
                'township' => $invoice->customer_name->township,
                'address' => $invoice->customer_name->address,
            ]);
        }



        return view('admin.invoices.show', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $invoice->delete();

        return back();
    }

    public function massDestroy(MassDestroyInvoiceRequest $request)
    {
        Invoice::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function showTrash()
    {
        $invoices = Invoice::onlyTrashed()->paginate(10);
        return view('admin.invoices.trashList', compact('invoices'));
    }

    public function restoreTrash($id)
    {
        $invoice = Invoice::withTrashed()->find($id)->restore();
        return redirect()->route('admin.invoices.index');
    }

    public function createPDF($id)
    {
        $invoice = Invoice::where('id', $id)->with('customer_name', 'created_by', 'products')->first();
        // dd($invoice->toArray());
        $pdf = PDF::loadView('admin/invoices/pdf', compact('invoice'))->setOptions(['defaultFont' => 'Arial']);
        return $pdf->download('site-informations' . $invoice->invoice_code . '.pdf');
    }

    public function deleteProduct(Request $request)
    {
        $inv_prod = InvoiceProduct::where('invoice_id', $request->invoice_id)
            ->where('product_id', $request->product_id)
            ->select('qty', 'total', 'discount')
            ->get();

        $qty = $inv_prod[0]->qty;
        $total = $inv_prod[0]->total;
        $discount = $inv_prod[0]->discount;

        $product_qty = Product::where('id', $request->product_id)
            ->select('total_stock_qty')
            ->get();

        $stock_qty = $product_qty[0]->total_stock_qty;
        $stock_qty += $qty;

        Product::where('id', $request->product_id)
            ->update([
                "total_stock_qty" => $stock_qty
            ]);

        $invoice = Invoice::where('id', $request->invoice_id)
            ->select('sub_total', 'total', 'total_qty')
            ->get();

        $sub_total = $invoice[0]->sub_total;
        $inv_total = $invoice[0]->total;
        $total_qty = $invoice[0]->total_qty;

        $sub_total -= $total;
        $inv_total = $sub_total - ($sub_total * $discount / 100);
        $total_qty -= $qty;

        Invoice::where('id', $request->invoice_id)
            ->update([
                "sub_total" => $sub_total,
                "total" => $inv_total,
                "total_qty" => $total_qty
            ]);

        InvoiceProduct::where('invoice_id', $request->invoice_id)
            ->where('product_id', $request->product_id)
            ->delete();

        return "Product deleted successfully";
    }

    public function exportSiteInformations(Request $request)
    {
        return Excel::download(new ExportInvoice, 'site-informations.xlsx');
    }

    public function uploadCodes(Request $request)
    {
        Excel::import(new InvoicesImport, $request->file);

        return redirect()->back();
    }
}
