<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use App\Models\Inquiry;
use App\Models\PurchaseOrder;
use App\Models\UserPayment;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    
    public function inquiry()
    {
        $company = DB::table('company')
            ->where('deleted_at',null)
            ->get();
        
        $material = DB::table('material')
            ->where('deleted_at',null)
            ->get();
        
        $data = DB::table('inquiry')
            ->select('material.name as material_name','company.name as company_name',"inquiry.*","company.distribution_channel","material.description as desc")
            ->join('company', 'inquiry.company_id', '=', 'company.id')
            ->join('material', 'inquiry.material_id', '=', 'material.id')
            ->where('inquiry.deleted_at',null)
            ->get();

        return view('user.inquiry')
            ->with('company', $company)
            ->with('material', $material)
            ->with('data', $data);
    }

    public function inquiry_action(Request $request)
    {
        $request->validate([
            'material_id' => 'required',
            'company_id' => 'required',
            'order_quantity' => 'required',
        ]);

        $inq = new Inquiry([
            'material_id' => $request->material_id,
            'company_id' => $request->company_id,
            'order_quantity' => $request->order_quantity,
        ]);

        $inq->save();

        $company = DB::table('company')
            ->where('deleted_at',null)
            ->get();
        
        $material = DB::table('material')
            ->where('deleted_at',null)
            ->get();
        
        $data = DB::table('inquiry')
            ->select('material.name as material_name','company.name as company_name',"inquiry.*","company.distribution_channel","material.description as desc")
            ->join('company', 'inquiry.company_id', '=', 'company.id')
            ->join('material', 'inquiry.material_id', '=', 'material.id')
            ->where('inquiry.deleted_at',null)
            ->get();

        return view('user.inquiry')
            ->with('company', $company)
            ->with('material', $material)
            ->with('data', $data);
    }
    
    public function quotation()
    {
                
        $data = DB::table('quotation')
            ->where('deleted_at',null)
            ->get();

        return view('user.quotation')
            ->with('data', $data);
    }

    
    public function purchase_order()
    {
        $data = DB::table('purchase_order')
            ->select('material.name as material_name','company.name as company_name',"purchase_order.*","company.distribution_channel","material.description as desc")
            ->join('company', 'purchase_order.company_id', '=', 'company.id')
            ->join('material', 'purchase_order.material_id', '=', 'material.id')
            ->where('purchase_order.deleted_at',null)
            ->get();
        
        $company = DB::table('company')
            ->where('deleted_at',null)
            ->get();
        
        $inquiry = DB::table('inquiry')
            ->where('deleted_at',null)
            ->get();
        
        $material = DB::table('material')
            ->where('deleted_at',null)
            ->get();

        return view('user.purchase-order')
        ->with('inquiry', $inquiry)
        ->with('company', $company)
        ->with('material', $material)
        ->with('data', $data);
    }

    public function purchase_order_action(Request $request)
    {
        $request->validate([
            'inquiry_id' => 'required',
            'material_id' => 'required',
            'company_id' => 'required',
            'quantity' => 'required',
            'delivery_date' => 'required',
            'delivery_address' => 'required',
        ]);

        $po = new PurchaseOrder([
            'inquiry_id' => $request->inquiry_id,
            'material_id' => $request->material_id,
            'company_id' => $request->company_id,
            'quantity' => $request->quantity,
            'delivery_date' => $request->delivery_date,
            'delivery_address' => $request->delivery_address,
        ]);

        $po->save();

        
        $log = new Logs([
            'document_type' => "purchase_order",
            'document_id' => $po->id,
            'action' => "create",
        ]);
        $log->save();


        $data = DB::table('purchase_order')
            ->select('material.name as material_name','company.name as company_name',"purchase_order.*","company.distribution_channel","material.description as desc")
            ->join('company', 'purchase_order.company_id', '=', 'company.id')
            ->join('material', 'purchase_order.material_id', '=', 'material.id')
            ->where('purchase_order.deleted_at',null)
            ->get();
        
        $company = DB::table('company')
            ->where('deleted_at',null)
            ->get();
                
         $inquiry = DB::table('inquiry')
            ->where('deleted_at',null)
            ->get();
            
        $material = DB::table('material')
            ->where('deleted_at',null)
            ->get();
            
        return view('user.purchase-order')
        ->with('company', $company)
        ->with('inquiry', $inquiry)
        ->with('material', $material)
        ->with('data', $data);
    
    }

    
    public function payment()
    {
        $company = DB::table('company')
            ->where('deleted_at',null)
            ->get();

        $billing = DB::table('billing_document')
            ->where('deleted_at',null)
            ->get();

        $flagPayment = false;

        return view('user.payment')
            ->with('company', $company)
            ->with('flagPayment', $flagPayment)
            ->with('billing', $billing);
    }

    public function payment_action(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'billing_id' => 'required',
            'bank_account' => 'required',
            'bank_name' => 'required',
            'payment_method' => 'required',
        ]);

        $po = new UserPayment([
            'company_id' => $request->company_id,
            'billing_id' => $request->billing_id,
            'bank_account' => $request->bank_account,
            'bank_name' => $request->bank_name,
            'payment_method' => $request->payment_method,
        ]);

        $po->save();

        $log = new Logs([
            'document_type' => "user_payment",
            'document_id' => $po->id,
            'action' => "create",
        ]);
        $log->save();

        $company = DB::table('company')
            ->where('deleted_at',null)
            ->get();

        $billing = DB::table('billing_document')
            ->where('deleted_at',null)
            ->get();

        $flagPayment = true;

        return view('user.payment')
            ->with('company', $company)
            ->with('flagPayment', $flagPayment)
            ->with('billing', $billing);
    }


}
