<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cocktail extends Model
{
    use HasFactory;
    //we use fillable as protection
    protected $fillable =[
        'name',
        'description',
        'instructions',
        'image',
        'type_id',
    ];

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function ingredients(){
        return $this->belongsToMany(Ingredient::class);
    }
}
