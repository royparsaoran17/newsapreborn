<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'material';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'quantity',
        'warehouse_number',
        'price',
        'description',
    ];
}
