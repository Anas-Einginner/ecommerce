<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;
    protected $table = 'setting_payment'; 

    protected $fillable = ['key', 'value'];



    

}
