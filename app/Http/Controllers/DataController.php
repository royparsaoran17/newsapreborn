<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use App\Models\Company;
use App\Models\Inquiry;
use App\Models\PurchaseOrder;
use App\Models\UserPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DataController extends Controller
{
    public function dropdown_company($id)
    {
        $company = DB::table('company')
            ->where('id',$id)
            ->first();

        return $company;
    }

    public function dropdown_material($id)
    {
        $material = DB::table('material')
            ->where('id',$id)
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
            ->first();

        return $data;
    }

    public function admin_dropdown_inquiry($id)
    {
        $data = DB::table('inquiry')
            ->select('material.name as material_name',"inquiry.*",'material.description')
            ->join('material', 'inquiry.material_id', '=', 'material.id')
            ->where('inquiry.id',$id)
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
            ->first();
        // echo json_encode($data);
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
            ->first();

        return $data;
    }

    public function admin_dropdown_accounting_document($id)
    {
        $data = DB::table('accounting_document')
            ->where('billing_document_id',$id)
            ->first();

        return $data;
    }
}
