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
use App\Models\Logs;
use App\Models\MaterialPurchasing;
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
            ->where('quotation.deleted_at',null)
            ->get();

        $inquiry = DB::table('inquiry')
            ->where('deleted_at',null)
            ->get();

        // dd($inquiry);
            
        $users = DB::table('users')
            ->where('email','!=','admin@email.com')
            ->where('deleted_at',null)
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
            'net_value' => str_replace(".","",str_replace("Rp","",$request->net_value)),
        ]);

        $quo->save();

        
        $log = new Logs([
            'document_type' => "quotation",
            'document_id' => $quo->id,
            'action' => "create",
        ]);
        $log->save();

        $data = DB::table('quotation')
            ->select('users.name as user_name','material.name as material_name',"quotation.*",'inquiry.material_id','inquiry.order_quantity')
            ->join('inquiry', 'quotation.inquiry_id', '=', 'inquiry.id')
            ->join('users', 'quotation.customer_id', '=', 'users.id')
            ->join('material', 'inquiry.material_id', '=', 'material.id')
            ->where('quotation.deleted_at',null)
            ->get();

        $inquiry = DB::table('inquiry')
            ->where('deleted_at',null)
            ->get();
        
        $users = DB::table('users')
            ->where('email','!=','admin@email.com')
            ->where('deleted_at',null)
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
            ->where('deleted_at',null)
            ->get();

        $users = DB::table('users')
            ->where('deleted_at',null)
            ->where('email','!=','admin@email.com')
            ->get();

        $data = DB::table('sales_order')
            ->select('users.name as user_name','users.id as customer_id','material.name as material_name','material.id as material_id','sales_order.id as id','sales_order.*',"purchase_order.quantity")
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('material', 'purchase_order.material_id', '=', 'material.id')
            ->where('sales_order.deleted_at',null)
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

        $log = new Logs([
            'document_type' => "sales_order",
            'document_id' => $quo->id,
            'action' => "create",
        ]);
        $log->save();

        $docs_flow = new DocumentFlow([
            'sales_order_id' => $quo->id,
            'sales_order_created_at' => $quo->created_at,
        ]);
        $docs_flow->save();

        $po = DB::table('purchase_order')
            ->where('deleted_at',null)
            ->get();
        
            
        $users = DB::table('users')
            ->where('email','!=','admin@email.com')
            ->where('deleted_at',null)
            ->get();

        $data = DB::table('sales_order')
            ->select('users.name as user_name','users.id as customer_id','material.name as material_name','material.id as material_id','sales_order.id as id','sales_order.*',"purchase_order.quantity")
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('material', 'purchase_order.material_id', '=', 'material.id')
            ->where('sales_order.deleted_at',null)
            ->get();
        
        return view('admin.sales-order')
        ->with('po', $po)
        ->with('users', $users)
        ->with('data', $data);
    }

    public function outbound_delivery()
    {
        $so = DB::table('sales_order')
            ->where('deleted_at',null)
            ->get();

        $data = DB::table('outbound_delivery')
            ->select('users.name as user_name','material.name as material_name',"outbound_delivery.*",'sales_order.customer_id','sales_order.req_delivery_date','sales_order.material_id','purchase_order.quantity','material.warehouse_number')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('material', 'sales_order.material_id', '=', 'material.id')
            ->where('outbound_delivery.deleted_at',null)
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

        $log = new Logs([
            'document_type' => "outbound_delivery",
            'document_id' => $od->id,
            'action' => "create",
        ]);
        $log->save();


        $df = DB::table('document_flow')
            ->where('sales_order_id',$request->sales_order_id)
            ->where('deleted_at',null)
            ->first();

        DocumentFlow::where('id', $df->id)
            ->update([
                'outbound_delivery_id' =>  $od->id,
                'outbound_delivery_created_at' =>  $od->created_at,
            ]);

        
        $log = new Logs([
            'document_type' => "document_flow",
            'document_id' => $df->id,
            'action' => "update",
        ]);
        $log->save();
    

        $so = DB::table('sales_order')
            ->where('deleted_at',null)
            ->get();

        $data = DB::table('outbound_delivery')
            ->select('users.name as user_name','material.name as material_name',"outbound_delivery.*",'sales_order.customer_id','sales_order.req_delivery_date','sales_order.material_id','purchase_order.quantity','material.warehouse_number')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('material', 'sales_order.material_id', '=', 'material.id')
            ->where('outbound_delivery.deleted_at',null)
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
            ->where('outbound_delivery.deleted_at',null)
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

        
        $log = new Logs([
            'document_type' => "outbound_delivery",
            'document_id' => $id,
            'action' => "update",
        ]);
        $log->save();


        $so = DB::table('sales_order')
            ->where('deleted_at',null)
            ->get();

        $data = DB::table('outbound_delivery')
            ->select('users.name as user_name','material.name as material_name',"outbound_delivery.*",'sales_order.customer_id','sales_order.req_delivery_date','sales_order.material_id','purchase_order.quantity','material.warehouse_number')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('material', 'sales_order.material_id', '=', 'material.id')
            ->where('outbound_delivery.deleted_at',null)
            ->get();
        
        return view('admin.outbound-delivery')
        ->with('so', $so)
        ->with('data', $data);
    }

    public function transfer_order()
    {
        $ob = DB::table('outbound_delivery')
            ->where('deleted_at',null)
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

        
        $log = new Logs([
            'document_type' => "transfer_order",
            'document_id' => $od->id,
            'action' => "create",
        ]);
        $log->save();


        $ob = DB::table('outbound_delivery')
            ->where('deleted_at',null)
            ->get();
        

        return view('admin.transfer-order')
            ->with('ob', $ob);
    }

    public function stock_overview()
    {
        $data = DB::table('material')
            ->where('deleted_at',null)
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
                ->where('deleted_at',null)
                ->get();
    
            // dd($m[0]->quantity + $request->quantity);
            
            Material::where('id', $request->id)
                ->update(['quantity' =>  ($m[0]->quantity + $request->quantity)]);
        }

        $data = DB::table('material')
            ->where('deleted_at',null)
            ->get();

        return view('admin.stock-overview')
        ->with('data', $data);
    }

    public function billing_document()
    {
        $ob = DB::table('outbound_delivery')
            ->where('deleted_at',null)
            ->get();

        $data = DB::table('billing_document')
            ->select('users.name as user_name',"billing_document.*",'users.id as customer_id')
            ->join('outbound_delivery', 'outbound_delivery.id', '=', 'billing_document.outbound_delivery_id')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->where('billing_document.deleted_at',null)
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
            'net_value' => str_replace(".","",str_replace("Rp","",$request->net_value)),
            'material_id' => $request->material_id,
            'billed_quantity' => $request->billed_quantity,
            
        ]);

        $quo->save();

        
        $log = new Logs([
            'document_type' => "billing_document",
            'document_id' => $quo->id,
            'action' => "create",
        ]);
        $log->save();


        $df = DB::table('document_flow')
            ->where('outbound_delivery_id',$request->outbound_delivery_id)
            ->where('deleted_at',null)
            ->first();

        DocumentFlow::where('id', $df->id)
            ->update([
                'billing_id' =>  $quo->id,
                'billing_created_at' =>  $quo->created_at,
            ]);

            
        $log = new Logs([
            'document_type' => "document_flow",
            'document_id' => $df->id,
            'action' => "update",
        ]);
        $log->save();


        $ad = new AccountingDocument([
            'billing_document_id' => $quo->id,
            'total_amount' => str_replace(".","",str_replace("Rp","",$request->net_value)),
            'material_id' => $request->material_id,
            
        ]);

        $ad->save();

        
        $log = new Logs([
            'document_type' => "accounting_document",
            'document_id' => $ad->id,
            'action' => "update",
        ]);
        $log->save();


        $df = DB::table('document_flow')
        ->where('billing_id',$quo->id)
        ->where('deleted_at',null)
        ->first();

        DocumentFlow::where('id', $df->id)
            ->update([
                'accounting_id' =>  $ad->id,
                'accounting_created_at' =>  $ad->created_at,
            ]);

        
        $log = new Logs([
            'document_type' => "document_flow",
            'document_id' => $df->id,
            'action' => "update",
        ]);
        $log->save();
    

        BillingDocument::where('id', $quo->id)
            ->update(['invoice_id' =>  "11021" . $quo->id]);

            
        $ob = DB::table('outbound_delivery')
            ->where('deleted_at',null)
            ->get();

        $data = DB::table('billing_document')
            ->select('users.name as user_name',"billing_document.*",'users.id as customer_id')
            ->join('outbound_delivery', 'outbound_delivery.id', '=', 'billing_document.outbound_delivery_id')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->where('billing_document.deleted_at',null)
            ->get();
        
        return view('admin.billing-document')
        ->with('ob', $ob)
        ->with('data', $data);
    }

    public function accounting_document()
    {
        $data = DB::table('billing_document')
            ->where('deleted_at',null)
            ->get();

        $billing = DB::table('billing_document')
        ->select('users.name as user_name',"billing_document.*",'users.id as customer_id','material.name as material_name','material.id as material_id','material.price as price','material.description as description')
        ->join('material', 'billing_document.material_id', '=', 'material.id')
        ->join('outbound_delivery', 'outbound_delivery.id', '=', 'billing_document.outbound_delivery_id')
        ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
        ->join('users', 'sales_order.customer_id', '=', 'users.id')
        ->where('billing_document.deleted_at',null)
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
            ->where('deleted_at',null)
            ->get();

        $billing = DB::table('billing_document')
            ->select('users.name as user_name',"billing_document.*",'users.id as customer_id','material.name as material_name','material.id as material_id','material.price as price','material.description as description')
            ->join('material', 'billing_document.material_id', '=', 'material.id')
            ->join('outbound_delivery', 'outbound_delivery.id', '=', 'billing_document.outbound_delivery_id')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->where('billing_document.id',$request->billing_id)
            ->where('billing_document.deleted_at',null)
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
            ->where('deleted_at',null)
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
            'total_amount' => str_replace(".","",str_replace("Rp","",$request->total_amount)),
        ]);

        $quo->save();

        
        $log = new Logs([
            'document_type' => "incoming_payment",
            'document_id' => $quo->id,
            'action' => "create",
        ]);
        $log->save();


        $users = DB::table('users')
            ->where('email','!=','admin@email.com')
            ->where('deleted_at',null)
            ->get();

        return view('admin.incoming-payment')
        ->with('users', $users);
    }

    public function document_flow()
    {
        $data = DB::table('document_flow')
            ->where('deleted_at',null)
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
            ->where('deleted_at',null)
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

    public function material_purchasing()
    {
        $data = DB::table('material_purchasing')
            ->where('deleted_at',null)
            ->get();
        
        $material = DB::table('material')
            ->where('deleted_at',null)
            ->get();

        return view('admin.material-purchasing')
        ->with('material', $material)
        ->with('data', $data);
    }

    public function material_purchasing_action(Request $request)
    {
        $quo = new MaterialPurchasing([
            'material_id' => $request->material_id,
            'vendor' => $request->vendor,
            'quantity' => $request->quantity,
            'net_value' =>  str_replace(".","",str_replace("Rp","",$request->net_value)),
        ]);
        $quo->save();

        if ( $request->quantity != null) {
            $m = DB::table('material')
                ->where('id', $request->material_id)
                ->where('deleted_at',null)
                ->first();
    
            Material::where('id', $request->material_id)
                ->update(['quantity' =>  ($m->quantity + $request->quantity)]);
        }

        $log = new Logs([
            'document_type' => "material_purchasing",
            'document_id' => $quo->id,
            'action' => "buy ".$request->quantity." with price ".$request->net_value,
        ]);
        $log->save();

        $data = DB::table('material_purchasing')
            ->where('deleted_at',null)
            ->get();
        
        $material = DB::table('material')
            ->where('deleted_at',null)
            ->get();

        

        return view('admin.material-purchasing')
        ->with('material', $material)
        ->with('data', $data);
    }

    public function report(Request $request)
    {

        $data = DB::table('billing_document')
        ->select('billing_document.net_value as total','billing_document.billed_quantity as quantity','material.name as material_name','material.id as material_id','material.price as price','material.description as description','billing_document.created_at')
        ->join('material', 'billing_document.material_id', '=', 'material.id')
        ->where('billing_document.deleted_at',null)
        ->get();

        $sales = 0;
        foreach ($data as $key ) {
            $sales += $key->total;
        }
        

        return view('admin.report')
        ->with('sales', $sales)
        ->with('data', $data);
    }

    public function logs()
    {

        $data = DB::table('logs')
        ->get();

        return view('admin.logs')
        ->with('data', $data);
    }

    public function logs_action(Request $request)
    {
        
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'document_type' => 'required',
        ]);

        $data = DB::table('logs')
            ->where('created_at','>=',$request->start_date)
            ->where('created_at','<=',$request->end_date)
            ->where('document_type',$request->document_type)
            ->where('deleted_at',null)
            ->get();


        return view('admin.logs')
        ->with('data', $data);
    }

    public function report_action(Request $request)
    {

        $data = DB::table('billing_document')
            ->select('billing_document.net_value as total','billing_document.billed_quantity as quantity','material.name as material_name','material.id as material_id','material.price as price','material.description as description','billing_document.created_at as created_at')
            ->join('material', 'billing_document.material_id', '=', 'material.id')
            ->where('billing_document.created_at','>=',$request->start_date)
            ->where('billing_document.created_at','<=',$request->end_date)
            ->where('billing_document.deleted_at',null)
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
