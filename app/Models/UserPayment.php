<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    use HasFactory;

    protected $table = 'user_payment';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'billing_id',
        'bank_account',
        'bank_name',
        'payment_method',
    ];
}
