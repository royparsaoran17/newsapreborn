<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use App\Models\AccountingDocument;
use App\Models\BillingDocument;
use App\Models\DocumentFlow;
use App\Models\IncomingPayment;
use App\Models\Material;
use App\Models\OutboundDelivery;
use App\Models\Quotation;
use App\Models\SalesOrder;
use App\Models\TransferOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function quotation()
    {
        // $data = [];
        $data = DB::table('quotation')
            ->select('users.name as user_name','material.name as material_name',"quotation.*",'inquiry.material_id','inquiry.order_quantity')
            ->join('inquiry', 'quotation.inquiry_id', '=', 'inquiry.id')
            ->join('users', 'quotation.customer_id', '=', 'users.id')
            ->join('material', 'inquiry.material_id', '=', 'material.id')
            ->get();

        $inquiry = DB::table('inquiry')
            ->get();

        // dd($inquiry);
            
        $users = DB::table('users')
            ->where('email','!=','admin@email.com')
            ->get();

        return view('admin.quotation')
        ->with('inquiry', $inquiry)
        ->with('users', $users)
        ->with('data', $data);
    }   

    public function quotation_action(Request $request)
    {
        $request->validate([
            'inquiry_id' => 'required',
            'customer_id' => 'required',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'net_value' => 'required',
        ]);

        $quo = new Quotation([
            'inquiry_id' => $request->inquiry_id,
            'customer_id' => $request->customer_id,
            'valid_from' => $request->valid_from,
            'valid_to' => $request->valid_to,
            'net_value' => $request->net_value,
        ]);

        $quo->save();

        $data = DB::table('quotation')
            ->select('users.name as user_name','material.name as material_name',"quotation.*",'inquiry.material_id','inquiry.order_quantity')
            ->join('inquiry', 'quotation.inquiry_id', '=', 'inquiry.id')
            ->join('users', 'quotation.customer_id', '=', 'users.id')
            ->join('material', 'inquiry.material_id', '=', 'material.id')
            ->get();

        $inquiry = DB::table('inquiry')
            ->get();
        
        $users = DB::table('users')
            ->where('email','!=','admin@email.com')
            ->get();

        return view('admin.quotation')
        ->with('inquiry', $inquiry)
        ->with('users', $users)
        ->with('data', $data);
    }
    
    // public function purchase_order()
    // {
    //     $data = [];
    //     return view('admin.purchase-order',$data);
    // }
    
    public function sales_order()
    {
        $po = DB::table('purchase_order')
            ->get();

        $users = DB::table('users')
            ->where('email','!=','admin@email.com')
            ->get();

        $data = DB::table('sales_order')
            ->select('users.name as user_name','users.id as customer_id','material.name as material_name','material.id as material_id','sales_order.id as id','sales_order.*',"purchase_order.quantity")
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('material', 'purchase_order.material_id', '=', 'material.id')
            ->get();
        
        return view('admin.sales-order')
        ->with('po', $po)
        ->with('users', $users)
        ->with('data', $data);
    }

    public function sales_order_action(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'customer_id' => 'required',
            'material_id' => 'required',
            'purchase_order_id' => 'required',
            'req_delivery_date' => 'required',
        ]);

        $quo = new SalesOrder([
            'purchase_order_id' => $request->purchase_order_id,
            'company_id' => $request->company_id,
            'customer_id' => $request->customer_id,
            'material_id' => $request->material_id,
            'req_delivery_date' => $request->req_delivery_date,
        ]);

        $quo->save();

        $docs_flow = new DocumentFlow([
            'sales_order_id' => $quo->id,
            'sales_order_created_at' => $quo->created_at,
        ]);
        $docs_flow->save();

        $po = DB::table('purchase_order')
            ->get();
        
            
        $users = DB::table('users')
            ->where('email','!=','admin@email.com')
            ->get();

        $data = DB::table('sales_order')
            ->select('users.name as user_name','users.id as customer_id','material.name as material_name','material.id as material_id','sales_order.id as id','sales_order.*',"purchase_order.quantity")
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('material', 'purchase_order.material_id', '=', 'material.id')
            ->get();
        
        return view('admin.sales-order')
        ->with('po', $po)
        ->with('users', $users)
        ->with('data', $data);
    }

    public function outbound_delivery()
    {
        $so = DB::table('sales_order')
            ->get();

        $data = DB::table('outbound_delivery')
            ->select('users.name as user_name','material.name as material_name',"outbound_delivery.*",'sales_order.customer_id','sales_order.req_delivery_date','sales_order.material_id','purchase_order.quantity','material.warehouse_number')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('material', 'sales_order.material_id', '=', 'material.id')
            ->get();
        
        return view('admin.outbound-delivery')
        ->with('so', $so)
        ->with('data', $data);
    }

    public function outbound_delivery_action(Request $request)
    {
        $request->validate([
            'sales_order_id' => 'required',
            'shipping_point' => 'required',
            'selection_date' => 'required',
        ]);

        $od = new OutboundDelivery([
            'sales_order_id' => $request->sales_order_id,
            'shipping_point' => $request->shipping_point,
            'selection_date' => $request->selection_date,
            'goods_issue_status' => 0,
        ]);

        $od->save();

        $df = DB::table('document_flow')
            ->where('sales_order_id',$request->sales_order_id)
            ->first();
        DocumentFlow::where('id', $df->id)
            ->update([
                'outbound_delivery_id' =>  $od->id,
                'outbound_delivery_created_at' =>  $od->created_at,
            ]);

        $so = DB::table('sales_order')
            ->get();

        $data = DB::table('outbound_delivery')
            ->select('users.name as user_name','material.name as material_name',"outbound_delivery.*",'sales_order.customer_id','sales_order.req_delivery_date','sales_order.material_id','purchase_order.quantity','material.warehouse_number')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('material', 'sales_order.material_id', '=', 'material.id')
            ->get();
        
        return view('admin.outbound-delivery')
        ->with('so', $so)
        ->with('data', $data);
    }

    public function outbound_delivery_goodissue($id)
    {
        $data2 = DB::table('outbound_delivery')
            ->select('users.name as user_name','material.name as material_name',"outbound_delivery.*",'sales_order.customer_id','sales_order.req_delivery_date','sales_order.material_id','purchase_order.quantity','material.warehouse_number')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('material', 'sales_order.material_id', '=', 'material.id')
            ->where('outbound_delivery.id',$id)
            ->first();

        $qty = $data2->quantity;
        $id_material = $data2->material_id;

        $current = DB::table('material')
            ->where('id',$id_material)
            ->first();

        if($current->quantity >=  $qty){
            Material::where('id', $id_material)
                ->update(['quantity' =>  $current->quantity - $qty]);

            OutboundDelivery::where('id', $id)
            ->update(['goods_issue_status' =>  1]);
        }else{
            return redirect('outbound-delivery')->withErrors([
                'quantity' => 'Quantity is not enough',
            ]);
        }

        $so = DB::table('sales_order')
            ->get();

        $data = DB::table('outbound_delivery')
            ->select('users.name as user_name','material.name as material_name',"outbound_delivery.*",'sales_order.customer_id','sales_order.req_delivery_date','sales_order.material_id','purchase_order.quantity','material.warehouse_number')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('material', 'sales_order.material_id', '=', 'material.id')
            ->get();
        
        return view('admin.outbound-delivery')
        ->with('so', $so)
        ->with('data', $data);
    }

    public function transfer_order()
    {
        $ob = DB::table('outbound_delivery')
            ->get();
        
        return view('admin.transfer-order')
            ->with('ob', $ob);
    }

    public function transfer_order_action(Request $request)
    {
        $od = new TransferOrder([
            'warehouse_number' => $request->warehouse_number,
            'outbound_delivery' => $request->outbound_delivery_id
        ]);

        $od->save();

        $ob = DB::table('outbound_delivery')
            ->get();
        

        return view('admin.transfer-order')
            ->with('ob', $ob);
    }

    public function stock_overview()
    {
        $data = DB::table('material')
            ->get();
        
        return view('admin.stock-overview')
        ->with('data', $data);
    }

    public function stock_overview_action(Request $request)
    {
        
        if ( $request->warehouse_number != null) {
            Material::where('id', $request->id)
                ->update(['warehouse_number' =>  $request->warehouse_number]);
        }

        // dd($request->quantity);
        if ( $request->quantity != null) {
            $m = DB::table('material')
                ->where('id', $request->id)
                ->get();
    
            // dd($m[0]->quantity + $request->quantity);
            
            Material::where('id', $request->id)
                ->update(['quantity' =>  ($m[0]->quantity + $request->quantity)]);
        }

        $data = DB::table('material')
            ->get();

        return view('admin.stock-overview')
        ->with('data', $data);
    }

    public function billing_document()
    {
        $ob = DB::table('outbound_delivery')
        ->get();

        $data = DB::table('billing_document')
            ->select('users.name as user_name',"billing_document.*",'users.id as customer_id')
            ->join('outbound_delivery', 'outbound_delivery.id', '=', 'billing_document.outbound_delivery_id')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->get();
        
        return view('admin.billing-document')
        ->with('ob', $ob)
        ->with('data', $data);
    }

    public function billing_document_action(Request $request)
    {
        $request->validate([
            'outbound_delivery_id' => 'required',
            'billing_date' => 'required',
            'net_value' => 'required',
        ]);

        $quo = new BillingDocument([
            'outbound_delivery_id' => $request->outbound_delivery_id,
            'billing_date' => $request->billing_date,
            'net_value' => $request->net_value,
            'material_id' => $request->material_id,
            'billed_quantity' => $request->billed_quantity,
            
        ]);

        $quo->save();

        $df = DB::table('document_flow')
            ->where('outbound_delivery_id',$request->outbound_delivery_id)
            ->first();
        DocumentFlow::where('id', $df->id)
            ->update([
                'billing_id' =>  $quo->id,
                'billing_created_at' =>  $quo->created_at,
            ]);

        $ad = new AccountingDocument([
            'billing_document_id' => $quo->id,
            'total_amount' => $request->net_value,
            'material_id' => $request->material_id,
            
        ]);

        $ad->save();

        $df = DB::table('document_flow')
        ->where('billing_id',$quo->id)
        ->first();
        DocumentFlow::where('id', $df->id)
            ->update([
                'accounting_id' =>  $ad->id,
                'accounting_created_at' =>  $ad->created_at,
            ]);


        BillingDocument::where('id', $quo->id)
            ->update(['invoice_id' =>  "11021" . $quo->id]);

        $ob = DB::table('outbound_delivery')
        ->get();

        $data = DB::table('billing_document')
            ->select('users.name as user_name',"billing_document.*",'users.id as customer_id')
            ->join('outbound_delivery', 'outbound_delivery.id', '=', 'billing_document.outbound_delivery_id')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->get();
        
        return view('admin.billing-document')
        ->with('ob', $ob)
        ->with('data', $data);
    }

    public function accounting_document()
    {
        $data = DB::table('billing_document')
        ->get();

        $billing = DB::table('billing_document')
        ->select('users.name as user_name',"billing_document.*",'users.id as customer_id','material.name as material_name','material.id as material_id','material.price as price','material.description as description')
        ->join('material', 'billing_document.material_id', '=', 'material.id')
        ->join('outbound_delivery', 'outbound_delivery.id', '=', 'billing_document.outbound_delivery_id')
        ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
        ->join('users', 'sales_order.customer_id', '=', 'users.id')
        ->first();

        $flag = false;

        return view('admin.accounting-document')
        ->with('flag', $flag)
        ->with('billing', $billing)
        ->with('data', $data);
    }

    public function accounting_document_action(Request $request)
    {
        $data = DB::table('billing_document')
        ->get();

        $billing = DB::table('billing_document')
        ->select('users.name as user_name',"billing_document.*",'users.id as customer_id','material.name as material_name','material.id as material_id','material.price as price','material.description as description')
        ->join('material', 'billing_document.material_id', '=', 'material.id')
        ->join('outbound_delivery', 'outbound_delivery.id', '=', 'billing_document.outbound_delivery_id')
        ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
        ->join('users', 'sales_order.customer_id', '=', 'users.id')
        ->where('billing_document.id',$request->billing_id)
        ->first();

        $flag = true;
        return view('admin.accounting-document')
        ->with('billing', $billing)
        ->with('flag', $flag)
        ->with('data', $data);
    }

    public function incoming_payment()
    {
        
        $users = DB::table('users')
            ->where('email','!=','admin@email.com')
            ->get();

        return view('admin.incoming-payment')
        ->with('users', $users);
    }

    public function incoming_payment_action(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'bank_account' => 'required',
            'total_amount' => 'required',
        ]);

        $quo = new IncomingPayment([
            'document_date' => date('Y-m-d'),
            'posting_date' => date('Y-m-d'),
            'customer_id' => $request->customer_id,
            'bank_account' => $request->bank_account,
            'total_amount' => $request->total_amount,
        ]);

        $quo->save();

        $users = DB::table('users')
            ->where('email','!=','admin@email.com')
            ->get();

        return view('admin.incoming-payment')
        ->with('users', $users);
    }

    public function document_flow()
    {
        $data = DB::table('document_flow')
        ->first();

        $flag = false;
        return view('admin.document-flow')
        ->with('flag', $flag)
        ->with('data', $data);
    }

    public function document_flow_action(Request $request)
    {
        $data = DB::table('document_flow')
        ->where($request->document_type,$request->document_number)
        ->first();

        if (empty($data)) {
            return redirect('document-flow')->withErrors([
                'data' => 'Data not found',
            ]);
        }

        $flag = true;
        return view('admin.document-flow')
        ->with('flag', $flag)
        ->with('data', $data);
    }

    public function report(Request $request)
    {

        $data = DB::table('billing_document')
        ->select('billing_document.net_value as total','billing_document.billed_quantity as quantity','material.name as material_name','material.id as material_id','material.price as price','material.description as description','billing_document.created_at')
        ->join('material', 'billing_document.material_id', '=', 'material.id')
        ->get();

        $sales = 0;
        foreach ($data as $key ) {
            $sales += $key->total;
        }
        

        return view('admin.report')
        ->with('sales', $sales)
        ->with('data', $data);
    }

    public function report_action(Request $request)
    {

        $data = DB::table('billing_document')
            ->select('billing_document.net_value as total','billing_document.billed_quantity as quantity','material.name as material_name','material.id as material_id','material.price as price','material.description as description','billing_document.created_at as created_at')
            ->join('material', 'billing_document.material_id', '=', 'material.id')
            ->where('billing_document.created_at','>=',$request->start_date)
            ->where('billing_document.created_at','<=',$request->end_date)
            ->get();

        $sales = 0;
        foreach ($data as $key ) {
            $sales += $key->total;
        }

        return view('admin.report')
        ->with('sales', $sales)
        ->with('data', $data);
    }
}
