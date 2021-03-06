<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingMail extends Model
{
    use HasFactory;
    protected $fillable = [
        'mail_number',
        'letter_date',
        'sender',
        'destination',
        'about',
        'link',
        'file',
        'user_id',
    ];
}
