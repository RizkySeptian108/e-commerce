<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
        return $this->belongsTo(Kiosk::class)->orderBy('kiosk_name');
    }

    public function scopeFilter(Builder $query, array $filter ): void
    {
        $query->when($filter['search'] ?? false, function($query, $search){
            return $query->where('product_name', 'like', '%'. $search .'%');
        });

        $query->when($filter['category'] ?? false, function($query, $category){
            return $query->whereHas('category', function($query) use ($category){
                $query->where('category_id', $category);
            });
        });

        $query->when($filter['kiosk'] ?? false, function($query, $kiosk){
            return $query->whereHas('kiosk', function ($query) use ($kiosk){
                $query->where('kiosk_id', $kiosk);
            });
        });
    }

}
