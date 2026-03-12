<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heritage extends Model
{
    use HasFactory;
   protected $table = 'heritage_cards';

    protected $fillable = [
        'title',
        'description',
        'image',
        'order',
        'status',
    ];
}
