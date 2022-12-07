<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'quotation';
    protected $primaryKey = 'id';

    protected $fillable = [
        'inquiry_id',
        'customer_id',
        'valid_from',
        'valid_to',
        'net_value',
    ];
}
