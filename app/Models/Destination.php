<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location_id', 'description', 'img'];

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
        return asset("storage/images/" . $this->image);
    }
}

