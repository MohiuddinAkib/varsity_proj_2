<?php

namespace App\Contract;

use App\Models\Cow;

interface IMapService
{
    const PLACE_TYPE_VETERIANRY = "veterinary_care";

    public function geocode_from_location(string $address);

    public function search_nearby_veterinaries(int $radius, int $latitude, int $longitude);
}
