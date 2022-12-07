<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferOrder extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'transfer_order';
    protected $primaryKey = 'id';

    protected $fillable = [
        'warehouse_number',
        'outbound_delivery',
    ];
}
