<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Booking extends Model
{
    use Notifiable;
    protected $table = 'bookings';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'service_name', 'booking_name', 'booking_date', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function service() {
        return $this->hasOne('App\Models\Service','id','service_id');
    }

    public function user() {
        return $this->hasOne('App\User','id','user_id');
    }

}
