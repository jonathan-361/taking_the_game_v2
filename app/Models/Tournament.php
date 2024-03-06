<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;
    protected $table = 'tournaments';
    protected $fillable = ['name', 'season', 'category_id', 'gender'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function matches()
    {
        return $this->hasMany(Matche::class);
    }
}
