<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Access extends Model
{
    use HasFactory;

    protected $table = 'access';

    protected $fillable = ['access_type'];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
