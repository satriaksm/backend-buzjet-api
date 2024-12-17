<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'duration', 'night', 'capacity', 'created_by'];

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'package_destinations',  'package_id', 'destination_id');
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'package_hotels', 'package_id', 'hotel_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transportations()
    {
        return $this->belongsToMany(Transportation::class, 'package_transportations');
    }
}
