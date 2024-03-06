<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = ['role_name'];

    public function allowedElements()
    {
        return $this->hasMany(AllowedElement::class, 'role_id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
    public function menus()
    {
        return $this->hasMany(Menu::class, 'role_id');
    }
}
