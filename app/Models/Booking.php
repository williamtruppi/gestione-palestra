<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'lesson_id'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function lessons() {
        return $this->belongsTo(Lesson::class);
    }

}
