<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_img',
        'item_name',
        'brand',
        'price',
        'detail',
        'condition',
        'user_id',
        'sold'
    ];

    public function categories(){
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function shipment(){
        return $this->hasOne(Shipment::class);
    }

    public function purchase(){
        return $this->hasOne(Purchase::class);
    }
}
