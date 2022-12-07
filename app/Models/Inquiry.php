<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'inquiry';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'material_id',
        'order_quantity',
        'description',
    ];
}
