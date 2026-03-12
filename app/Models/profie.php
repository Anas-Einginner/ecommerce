<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profie extends Model
{
    use HasFactory;
    protected $guarded = []; 
    public function profie()
    {
    return $this->hasOne(\App\Models\profie::class);

    }
}
