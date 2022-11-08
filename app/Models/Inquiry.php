<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;
    
    protected $table = 'inquiry';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'material_id',
        'order_quantity',
        'description',
    ];
}
