<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'purchase_order';
    protected $primaryKey = 'id';

    protected $fillable = [
        'inquiry_id',
        'company_id',
        'material_id',
        'quantity',
        'delivery_date',
        'delivery_address',
    ];
}
