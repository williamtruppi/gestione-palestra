<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function customers() {
        return $this->hasMany(Customer::class);
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    public function lessons() {
        return $this->hasMany(Lesson::class);
    }

}
