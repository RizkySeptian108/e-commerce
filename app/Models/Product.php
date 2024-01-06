<?php

namespace App\Models;

use App\Models\Category;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name', 
        'category_id', 
        'qty', 
        'unit', 
        'price_per_unit', 
        'description', 
        'product_picture', 
        'kiosk_id'
    ];

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function kiosk():BelongsTo
    {
        return $this->belongsTo(Kiosk::class);
    }

}
