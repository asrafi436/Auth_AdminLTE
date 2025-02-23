<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Define which attributes can be mass-assigned
    protected $fillable = [
        'name',
        'category',
        'price',
        'image',
        'short_description',
        'long_description',
        'stock',
        'status',
        'seo_tags',
    ];
}
