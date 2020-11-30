<?php

namespace App\Models;

use App\Facades\Services\LocationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'code',
        'description',
        'radius',
        'radius_unit',
        'start_at',
        'end_at',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function isDistanceInRange($originLatLong, $destinationLatLong)
    {
        $distance = LocationService::setOriginLatLong($originLatLong)
            ->setDestinationLatLong($destinationLatLong)
            ->setUnit($this->radius_unit)
            ->getDistance();

        return $distance <= $this->radius;
    }
}
