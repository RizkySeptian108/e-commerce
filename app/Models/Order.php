<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'kiosk_id', 'total_price', 'address', 'payment_id', 'shipment_id'];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
