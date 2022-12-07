<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPayment extends Model
{
    use HasFactory, SoftDeletes;

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
