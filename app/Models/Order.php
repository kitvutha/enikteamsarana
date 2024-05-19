<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_post_id', 'user_id', 'quantity', 'total_price'
    ];

    // Define relationship with ProductPost
    public function productPost()
    {
        return $this->belongsTo(ProductPost::class);
    }
}
