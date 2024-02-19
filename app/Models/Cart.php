<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'qty', 'kiosk_id'];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function kiosk():BelongsTo
    {
        return $this->belongsTo(Kiosk::class, 'kiosk_id');
    }
}
