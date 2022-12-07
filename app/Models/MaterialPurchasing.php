<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialPurchasing extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'material_purchasing';
    protected $primaryKey = 'id';

    protected $fillable = [
        'material_id',
        'quantity',
        'vendor',
        'net_value',
    ];
}
