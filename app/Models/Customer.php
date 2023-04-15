<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'card_id',
        'membership_type',
        'membership_duration',
        'membership_status'
    ];

    public static function getCustomers($fltArr = array()) {

        $customers = Customer::query()
        ->select('customers.*', 'cards.id as card_id', 'cards.code as card_code')
        ->leftJoin('cards', 'customers.card_id', '=', 'cards.id')
        ->where(function ($query) use ($fltArr) {
            foreach ($fltArr as $k => $v) {
                if ($v == '' || $k == 'cards' || $k == 'bookings') {
                    continue;
                } else {
                    $query->where($k, '=', $v);
                }
            }
        });

        if ($fltArr['bookings']) {
            $customers = $customers->with('bookings');
        }
        
        $customers = $customers->orderBy('customers.id', 'asc')
        ->get();

        return $customers;

    }

    public function courses() {
        return $this->hasMany(Course::class);
    }

    public function card() {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

}
