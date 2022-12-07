<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;

use App\Models\AccountingDocument;
use App\Models\BillingDocument;
use App\Models\Company;
use App\Models\DocumentFlow;
use App\Models\IncomingPayment;
use App\Models\Inquiry;
use App\Models\Material;
use App\Models\OutboundDelivery;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\Report;
use App\Models\UserPayment;
use App\Models\SalesOrder;
use App\Models\TransferOrder;
use App\Models\User;
use App\Models\Logs;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DataController extends Controller
{
    public function dropdown_company($id)
    {
        $company = DB::table('company')
            ->where('id',$id)
            ->where('deleted_at',null)
            ->first();

        return $company;
    }

    public function dropdown_material($id)
    {
        $material = DB::table('material')
            ->where('id',$id)
            ->where('deleted_at',null)
            ->first();

        return $material;
    }

    public function dropdown_quotation($id)
    {
        $data = DB::table('quotation')
            ->select('users.name as user_name','material.name as material_name',"quotation.*",'inquiry.material_id','inquiry.order_quantity','company.name as company_name','company.distribution_channel','material.description')
            ->join('inquiry', 'quotation.inquiry_id', '=', 'inquiry.id')
            ->join('company', 'inquiry.company_id', '=', 'company.id')
            ->join('users', 'quotation.customer_id', '=', 'users.id')
            ->join('material', 'inquiry.material_id', '=', 'material.id')
            ->where('quotation.id',$id)
            ->where('quotation.deleted_at',null)
            ->first();

        return $data;
    }

    public function dropdown_billing_document($id)
    {
        $data = DB::table('billing_document')
            ->select('material.description','material.name as material_name','company.name as company_name','users.name as user_name',"billing_document.*",'users.id as customer_id','sales_order.company_id')
            ->join('outbound_delivery', 'outbound_delivery.id', '=', 'billing_document.outbound_delivery_id')
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('company', 'sales_order.company_id', '=', 'company.id')
            ->join('material', 'sales_order.material_id', '=', 'material.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->where('billing_document.id',$id)
            ->where('billing_document.deleted_at',null)
            ->first();

        return $data;
    }

    public function dropdown_inquiry($id)
    {
        $data = DB::table('inquiry')
            ->select('company.name as company_name','material.name as material_name',"inquiry.*")
            ->join('company', 'inquiry.company_id', '=', 'company.id')
            ->join('material', 'inquiry.material_id', '=', 'material.id')
            ->where('inquiry.id',$id)
            ->where('inquiry.deleted_at',null)
            ->first();

        return $data;
    }

    public function admin_dropdown_inquiry($id)
    {
        $data = DB::table('inquiry')
            ->select('material.name as material_name','material.price as material_price',"inquiry.*",'material.description')
            ->join('material', 'inquiry.material_id', '=', 'material.id')
            ->where('inquiry.id',$id)
            ->where('inquiry.deleted_at',null)
            ->first();

        return $data;
    }
    

    public function admin_dropdown_purchase_order($id)
    {
        $data = DB::table('purchase_order')
            ->select("company.distribution_channel",'company.name as company_name','material.name as material_name',"material.id as material_id","purchase_order.quantity","inquiry.*",'material.description')
            ->join('material', 'purchase_order.material_id', '=', 'material.id')
            ->join('company', 'purchase_order.company_id', '=', 'company.id')
            ->join('inquiry', 'purchase_order.inquiry_id', '=', 'inquiry.id')
            ->where('purchase_order.id',$id)
            ->where('purchase_order.deleted_at',null)
            ->first();

        return $data;
    }

    public function admin_dropdown_sales_order($id)
    {
        $data = DB::table('sales_order')
            ->select('users.name as customer_name','material.name as material_name',"material.id as material_id","purchase_order.quantity","sales_order.*",'material.description',"material.warehouse_number as warehouse_number")
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('material', 'purchase_order.material_id', '=', 'material.id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('inquiry', 'purchase_order.inquiry_id', '=', 'inquiry.id')
            ->where('sales_order.id',$id)
            ->where('sales_order.deleted_at',null)
            ->first();
        return $data;
    }

    public function admin_dropdown_outbound_delivery($id)
    {
        $data = DB::table('outbound_delivery')
            ->select('users.name as customer_name','material.name as material_name',"material.id as material_id","purchase_order.quantity","sales_order.*",'material.description',"material.warehouse_number as warehouse_number","quotation.net_value")
            ->join('sales_order', 'outbound_delivery.sales_order_id', '=', 'sales_order.id')
            ->join('purchase_order', 'sales_order.purchase_order_id', '=', 'purchase_order.id')
            ->join('inquiry', 'purchase_order.inquiry_id', '=', 'inquiry.id')
            ->join('quotation', 'inquiry.id', '=', 'quotation.inquiry_id')
            ->join('users', 'sales_order.customer_id', '=', 'users.id')
            ->join('material', 'purchase_order.material_id', '=', 'material.id')
            ->where('outbound_delivery.id',$id)
            ->where('outbound_delivery.deleted_at',null)
            ->first();

        return $data;
    }

    public function admin_dropdown_accounting_document($id)
    {
        $data = DB::table('accounting_document')
            ->where('billing_document_id',$id)
            ->where('deleted_at',null)
            ->first();

        return $data;
    }

    
    public function user_delete(Request $request)
    {
        User::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "user",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();
        
        return back()->with('success', 'Post Deleted successfully');
    }

    public function accounting_document_delete(Request $request)
    {
        AccountingDocument::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "accounting_document",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();
        
        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function billing_document_delete(Request $request)
    {
        BillingDocument::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "billing_document",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();
        
        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function company_delete(Request $request)
    {
        Company::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "company",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();
        
        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function document_flow_delete(Request $request)
    {
        DocumentFlow::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "document_flow",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();
        
        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function incoming_payment_delete(Request $request)
    {
        IncomingPayment::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "incoming_payment",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();
        
        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function inquiry_delete(Request $request)
    {
        Inquiry::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "inquiry",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();
        
        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function material_delete(Request $request)
    {
        Material::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "material",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();
        
        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function outbound_delivery_delete(Request $request)
    {
        OutboundDelivery::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "outbound_delivery",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();
        
        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function purchase_order_delete(Request $request)
    {
        PurchaseOrder::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "purchase_order",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();
        
        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function quotation_delete(Request $request)
    {
        Quotation::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "quotation",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();
        
        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function report_delete(Request $request)
    {
        Report::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "report",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();
        
        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function sales_order_delete(Request $request)
    {
        SalesOrder::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "sales_order",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();

        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function transfer_order_delete(Request $request)
    {
        TransferOrder::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "transfer_order",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();

        return back()->with('success', 'Post Deleted successfully');
    }
    
    public function user_payment_delete(Request $request)
    {
        UserPayment::find($request->id)->delete();

        $log = new Logs([
            'document_type' => "user_payment",
            'document_id' => $request->id,
            'action' => "delete",
        ]);
        $log->save();

        return back()->with('success', 'Post Deleted successfully');
    }
}
