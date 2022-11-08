<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDocument extends Model
{
    use HasFactory;
    
    protected $table = 'billing_document';
    protected $primaryKey = 'id';

    protected $fillable = [
        'outbound_delivery_id',
        'invoice_id',
        'billing_date',
        'material_id',
        'billed_quantity',
        'net_value',
        'tax_amount',
        'discount',
    ];
}
