<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    
    protected $table = 'report';
    protected $primaryKey = 'id';

    protected $fillable = [
        'material_id',
        'sales_amount',
    ];
}
