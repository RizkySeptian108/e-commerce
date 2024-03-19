<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'kiosk_id', 'total_price', 'address', 'payment_id', 'shipment_id'];

    public function scopeFilter(Builder $query, array $filter ): void
    {
        $query->when($filter['kiosk_id'] ?? false, function($query, $kiosk_id){
            return $query->where('kiosk_id', $kiosk_id)->where('is_confirm', null);
        });

        $query->when($filter['is_confirm'] ?? false, function($query, $is_confirm){
            return $query->where('is_confirm', $is_confirm);
        });

    }

    
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
