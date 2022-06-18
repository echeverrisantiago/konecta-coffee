<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Sales extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'product_id',
        'quantity'
    ];

    public static $rules = [
        'product_id' => 'required',
        'quantity'   => 'required|numeric'
    ];

    public function Producto() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
