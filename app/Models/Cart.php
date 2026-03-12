<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Product::class)
            ->select('id', 'name', 'price', 'image')
            ->withDefault([
                'name' => 'Product',
                'price' => 0,
                'image' => 'default.png'
            ]);
    }
}
