<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowed_Element extends Model
{
    use HasFactory;
    protected $table = 'allowed_elements';
    protected $fillable = ['role_id', 'permission_id', 'element_id'];
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function element()
    {
        return $this->belongsTo(Element::class);
    }
}
