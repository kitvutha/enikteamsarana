<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;    
    protected $table = "table_product";

    protected $fillable = ['title', 'image', 'parent_id', 'status'];
}
