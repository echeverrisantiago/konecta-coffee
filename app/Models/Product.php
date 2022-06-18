<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'reference',
        'price',
        'weight',
        'category',
        'stock'
    ];

    public static $rules = [
        'name'      => 'required',
        'reference' => 'required',
        'price'     => 'required',
        'weight'    => 'required',
        'category'  => 'required',
        'stock'     => 'required'
    ];
}
