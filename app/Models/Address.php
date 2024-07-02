<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'is_main', 'recipient_name', 'phone_number', 'address_label', 'address_benchmark', 'full_address', 'latitude', 'longitude'];

    // changing main address
    public static function toggleMain($addressId)
    {
        $address = self::find($addressId);

        if ($address) {
            // Set all addresses of the user to not be main
            self::where('user_id', $address->user_id)->update(['is_main' => false]);

            // Set the selected address to be main
            $address->is_main = true;
            $address->save();
        }
    }
}
