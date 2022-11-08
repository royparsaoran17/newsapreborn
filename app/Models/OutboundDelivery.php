<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutboundDelivery extends Model
{
    use HasFactory;
    
    protected $table = 'outbound_delivery';
    protected $primaryKey = 'id';

    protected $fillable = [
        'sales_order_id',
        'shipping_point',
        'selection_date',
        'goods_issue_status',
    ];
}
