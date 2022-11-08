<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingDocument extends Model
{
    use HasFactory;
    
    protected $table = 'accounting_document';
    protected $primaryKey = 'id';

    protected $fillable = [
        'billing_document_id',
        'material_id',
        'total_amount',
    ];
}
