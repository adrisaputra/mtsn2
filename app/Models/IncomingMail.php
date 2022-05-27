<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingMail extends Model
{
    use HasFactory;
    protected $fillable = [
        'mail_number',
        'letter_date',
        'entry_date',
        'sender',
        'about',
        'link',
        'file',
        'user_id',
    ];
}
