<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'location_id', 'img'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_destinations');
    }

    public function getImageUrlAttribute()
    {
        if ($this->img) {
            return asset('storage/destinations/' . $this->img);
        }
        return null;
    }
}
