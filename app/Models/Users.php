<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = ['name', 'first_surname', 'second_surname', 'password', 'date_of_birth', 'gender', 'email', 'phone', 'role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function ownedTeams()
    {
        return $this->hasMany(Team::class, 'team_owner_id');
    }
    public function player()
    {
        return $this->hasOne(Player::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
