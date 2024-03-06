<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    use HasFactory;
    protected $table = 'elements';
    protected $fillable = ['element_name'];

    public function allowedElements()
    {
        return $this->hasMany(AllowedElement::class, 'element_id');
    }
    public function menus()
    {
        return $this->hasMany(Menu::class, 'element_id');
    }
}
