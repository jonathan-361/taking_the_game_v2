<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_Reason extends Model
{
    use HasFactory;
    protected $table = 'payment_reasons';
    protected $fillable = ['payment_reason_name'];

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}
