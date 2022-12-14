<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'sales_order';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'customer_id',
        'purchase_order_id',
        'material_id',
        'req_delivery_date',
    ];
}
