<?php

namespace App\Models;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    // name	price	description	stock	expiry_date	dosage	brand	category_id	supplier_id
    protected $fillable = [
        'name',
        'price',
        'description',
        'stock',
        'expiry_date',
        'dosage',
        'brand',
        'category_id',
        'supplier_id',
        // 'purchase_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

// public function saleItems()
// {
//     return $this->belongsToMany(Sale::class, 'sale_products')
//     ->withPivot('quantity', 'price'); // A product can appear in many sales
// }
// public function orderItems()
// {
//     return $this->belongsToMany(Order::class, 'order_products')
//         ->withPivot('quantity', 'price'); // A product can appear in many orders
// }
