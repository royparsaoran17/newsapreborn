<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFlow extends Model
{
    use HasFactory;
    
    protected $table = 'document_flow';
    protected $primaryKey = 'id';

    protected $fillable = [
        'sales_order_id',
        'sales_order_created_at',
        'outbound_delivery_id',
        'outbound_delivery_created_at',
        'billing_id',
        'billing_created_at',
        'accounting_id',
        'accounting_created_at',
    ];
}
