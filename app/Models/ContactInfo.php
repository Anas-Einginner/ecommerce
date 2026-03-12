<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'email',
        'support_email',
        'facebook',
        'instagram',
        'twitter',
        'pinterest'
    ];
}
