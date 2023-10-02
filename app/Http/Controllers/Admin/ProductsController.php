<?php

namespace App\Http\Controllers\Admin;

use App\Models\InvoiceProduct;
use Gate;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Exports\ExportStock;
use Illuminate\Http\Request;
use App\Models\CustomerAssign;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyProductRequest;

class ProductsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::with(['created_by'])->whereNull('parent_id')->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $request['total_stock_qty'] = $request->stock_qty;
        $request['total_length'] = $request->length;
        $request['status'] = 'in';
        $product = Product::create($request->all());

        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category_names = Category::pluck('category_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $product->load('created_by');
        // dd($product);

        return view('admin.products.edit', compact('category_names', 'product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {

        $products = $product;

        if ($request->stock_qty != $product->total_stock_qty) {

            $invoice_qty = InvoiceProduct::where('product_id' , $product->id)->groupBy('product_id')->sum('qty');
            $product_qty = Product::where('parent_id' , $product->id)->groupBy('parent_id')->sum('stock_qty');
            $total_qty = ($request->stock_qty - $invoice_qty) + $product_qty;
            $products['total_stock_qty'] = $total_qty;
            $products['stock_qty'] = $request->stock_qty;

            // $product->update([
            //     'total_stock_qty' => $total_qty,
            //     'stock_qty' => $request->stock_qty
            // ]);
        }

        if( $request->total_length != $product->total_length)
        {

            $invoice_drum_no = Invoice::where('cable_drum_no' , $product->drum_no)->groupBy('cable_drum_no')->sum('drop_cable_length');
            $product_drum_no = Product::where('drum_no' , $product->drum_no)->whereNotNull('parent_id')->groupBy('drum_no')->sum('length');
            $total_cable_length = ($request->total_length - $invoice_drum_no) + $product_drum_no;
            $products['total_length'] = $total_cable_length;

        }

        $products['length'] = $request->total_length;
        $products['onu_type'] = $request->onu_type;
        $products['onu_model_no'] = $request->onu_model_no;
        $products['ont_serial_no'] = $request->ont_serial_no;
        $products['onu'] = $request->onu;
        $products['drum_no'] = $request->drum_no;
        $products['patch_cord'] = $request->patch_cord;
        $products['drop_sleeve'] = $request->drop_sleeve;
        $products['sleeve_holder'] = $request->sleeve_holder;
        $products['product_name'] = $request->product_name;
        $products['model_no'] = $request->model_no;
        $products['price'] = $request->price;
        $products['discount'] = $request->discount;
        $products['description'] = $request->description;
        $products->save();



        return redirect()->route('admin.products.index');
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->load('productInvoices');

        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Product::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getPrice(Request $req)
    {
        $product = Product::where('id', $req->id)->first();
        return [
            (int) $product->price,
            (int) $product->total_stock_qty
        ];
    }

    public function showTrash()
    {
        $products = Product::onlyTrashed()->paginate(10);
        return view('admin.products.trashList', compact('products'));
    }

    public function restoreTrash($id)
    {
        $product = Product::withTrashed()->find($id)->restore();
        return redirect()->route('admin.products.index');
    }

    public function search(Request $request)
    {
        // This code is all details
        // $products = Product::where('product_name', 'LIKE', '%' . $request->search_data . '%')
        //     ->orWhere('model_no', 'LIKE', '%' . $request->search_data . '%')
        //     // ->with(['category_name', 'created_by'])
        //     ->paginate(10);


        // This code is last data
        $products = Product::with(['created_by'])->where(function ($query) use ($request) {
            $query->where('product_name', 'LIKE', '%' . $request->search_data . '%')
                ->orWhere('model_no', 'LIKE', '%' . $request->search_data . '%');
        })
            ->whereNull('parent_id')
            ->latest()
            ->paginate(10);
        $products->appends($request->all());
        return view('admin.products.index', compact('products'));
    }

    public function addStock(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();
        // dd($product);
        Product::create([
            'onu_type' => $product->onu_type,
            'onu_model_no' => $product->onu_model_no,
            'ont_serial_no' => $product->ont_serial_no,
            'onu' => $product->onu,
            'drum_no' => $product->drum_no,
            'patch_cord' => $product->patch_cord,
            'drop_sleeve' => $product->drop_sleeve,
            'sleeve_holder' => $product->sleeve_holder,
            'product_name' => $product->product_name,
            'price' => $product->price,
            'stock_qty' => $request->stock_qty ?? 0,
            'total_stock_qty' => 0,
            'length' => $request->length ?? 0,
            'total_length' => 0,
            'discount' => $product->discount,
            'description' => $product->description,
            'model_no' => $product->model_no,
            'parent_id' => $product->id,
            'status' => 'in',
            'site_id' => $product->site_id,
        ]);

        if ($request->stock_qty) {
            $product->update([
                'total_stock_qty' => $product->total_stock_qty + $request->stock_qty,
            ]);
        }

        if ($request->length) {
            $product->update([
                'total_length' => $product->total_length + $request->length,
            ]);
        }

        return redirect()->back();
    }

    public function __showInventory(Request $request)
    {
        // return $request->id;
        $id = collect($request->segments())->last();
        $products = [];

        $product_drum_no = Product::find($id)->drum_no;



        $in_products = Product::with('productInvoices')->where('status', 'in')->where(function ($query) use ($id) {
            $query->where('id', $id)->orWhere('parent_id', $id);
        })->get();

        $out_products = DB::table('invoice_product')->where('product_id', $id)->select(
                'invoice_product.*',
                'invoices.customer_name_id',
                'invoices.cable_drum_no',
                // 'invoices.drop_cable_length',
                'products.drum_no',
                'invoices.customer_assign'
            )
            ->join('invoices', 'invoice_product.invoice_id', '=', 'invoices.id')
            ->join('products', 'invoice_product.product_id', '=', 'products.id')
            ->orderByDesc('invoice_product.created_at')
            ->get();



        if(Invoice::where("cable_drum_no",$product_drum_no)->with('products')->first() != [])
        {
            $out_products[] = Invoice::where("cable_drum_no",$product_drum_no)->with('products')->get();
        }

        return $out_products;


        foreach ($in_products as $product) {
            array_push($products, [
                'date' => date('d-m-Y', strtotime($product->created_at)),
                'status' => $product->status,
                'site' => [],
                'qty' => $product->stock_qty ?? 0,
                'length' => $product->length ?? 0,
            ]);
        }

        foreach ($out_products as $product) {
            // return $product;
            array_push($products, [
                'date' => date('d-m-Y', strtotime($product->created_at ?? "")),
                'status' => 'out',
                'site' => [
                    'customer' => Customer::find($product->customer_name_id)->name ?? '',
                    'engineer' => CustomerAssign::find($product->customer_assign)->service_person->name ?? '',
                ],
                'qty' => $product->qty,
                // 'length' => ,
                'length'   =>$product->drop_cable_length ?? 0,
            ]);
        }
        $product = Product::find($id);
        $total_stock_qty = $product->total_stock_qty;
        $total_length = $product->total_length;
        $product_name = $product->product_name;

        return view('admin.products.inventory', compact('products', 'total_stock_qty', 'total_length', 'product_name'));
    }
    public function showInventory(Request $request)
    {

        $id = collect($request->segments())->last();
        $products = [];

        $product_drum_no = Product::find($id)->drum_no;

        $in_products = Product::with('productInvoices')->where('status', 'in')->where(function ($query) use ($id) {
            $query->where('id', $id)->orWhere('parent_id', $id);
        })->get();

        $out_products = DB::table('invoice_product')->where('product_id', $id)->select(
                'invoice_product.*',
                'invoices.customer_name_id',
                'invoices.cable_drum_no',
                // 'invoices.drop_cable_length',
                'products.drum_no',
                'invoices.customer_assign'
            )
            ->join('invoices', 'invoice_product.invoice_id', '=', 'invoices.id')
            ->join('products', 'invoice_product.product_id', '=', 'products.id')
            ->orderByDesc('invoice_product.created_at')
            ->get();



        if(Invoice::where("cable_drum_no",$product_drum_no)->with('products')->first() != [])
        {
            $invoices = Invoice::where("cable_drum_no",$product_drum_no)->with('products')->get();
            foreach($invoices as $invoice)
            {
                $out_products->push($invoice);
            }
        }

        foreach ($in_products as $product) {
            array_push($products, [
                'date' => date('d-m-Y', strtotime($product->created_at)),
                'status' => $product->status,
                'site' => [],
                'qty' => $product->stock_qty ?? 0,
                'length' => $product->length ?? 0,
            ]);
        }

        foreach ($out_products as $product) {
            array_push($products, [
                'date' => date('d-m-Y', strtotime($product->created_at ?? "")),
                'status' => 'out',
                'site' => [
                    'customer' => Customer::find($product->customer_name_id)->name ?? '',
                    'engineer' => CustomerAssign::find($product->customer_assign)->service_person->name ?? '',
                ],
                'qty' => $product->qty,
                'length'   =>$product->drop_cable_length ?? 0,
            ]);
        }
        $product = Product::find($id);
        $total_stock_qty = $product->total_stock_qty;
        $total_length = $product->total_length;
        $product_name = $product->product_name;

        return view('admin.products.inventory', compact('products', 'total_stock_qty', 'total_length', 'product_name'));
    }


    public function uploadProducts(Request $request)
    {
        Excel::import(new ProductsImport, $request->file);

        return redirect()->route('admin.products.index')->with('success', 'Product Imported Successfully');
    }

    public function export(Request $request)
    {
        return Excel::download(new ExportStock, 'stocks.xlsx');
    }
}
