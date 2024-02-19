<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kiosk extends Model
{
    use HasFactory;

    protected $table = 'kiosks';

    protected $fillable = ['user_id','kiosk_name', 'kiosk_description', 'kiosk_logo'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function cart():HasMany
    {
        return $this->hasMany(Cart::class);
    }
}
