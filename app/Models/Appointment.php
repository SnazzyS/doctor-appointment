<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'fee'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
