<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = ['user_id','due_date','team_id','payment_reason_id','amount','status'];

    public function payment_reason()
    {
        return $this->belongsTo(Payment_Reason::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
