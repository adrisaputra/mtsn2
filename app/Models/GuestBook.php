<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestBook extends Model
{
    use HasFactory;
    protected $fillable = [
        'guest_name',
        'phone_number',
        'agency_name',
        'destination_name',
        'necessity',
        'photo'
    ];
}
