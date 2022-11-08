<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferOrder extends Model
{
    use HasFactory;
    
    protected $table = 'transfer_order';
    protected $primaryKey = 'id';

    protected $fillable = [
        'warehouse_number',
        'outbound_delivery',
    ];
}
