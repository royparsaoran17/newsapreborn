<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingPayment extends Model
{
    use HasFactory;
    
    protected $table = 'incoming_payment';
    protected $primaryKey = 'id';

    protected $fillable = [
        'document_date',
        'posting_date',
        'customer_id',
        'bank_account',
        'total_amount',
    ];
}
