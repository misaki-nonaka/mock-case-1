<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'payment',
        'item_zipcode',
        'item_address',
        'item_building',
        'status'
    ];

    public function buyItem(){
        return $this->belongsTo(Item::class, 'item_id');
    }
}
