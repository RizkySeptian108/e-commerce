<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kiosk extends Model
{
    use HasFactory;

    protected $table = 'kiosks';

    protected $fillable = ['user_id','kiosk_name', 'kiosk_description', 'kiosk_logo'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
