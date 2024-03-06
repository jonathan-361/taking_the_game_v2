<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $fillable = ['role_id', 'element_id'];
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function element()
    {
        return $this->belongsTo(Element::class);
    }
}
