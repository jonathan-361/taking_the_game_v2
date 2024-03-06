<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $fillable = ['permission_name'];

    public function allowedElements()
    {
        return $this->hasMany(AllowedElement::class, 'permission_id');
    }
}
