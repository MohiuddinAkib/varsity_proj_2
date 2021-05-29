<?php


namespace App\Services;

use App\Contract\IMapService;
use Illuminate\Support\Facades\Http;

class MapService implements IMapService
{
    private string $api_token = "";

    public function __construct()
    {
        $this->api_token = $this->_get_token();
    }

    protected function _get_token()
    {
        return config("map.API_KEY");
    }

    public function geocode_from_location(string $address)
    {
        return Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
            "address" => $address,
            "key" => $this->api_token,
        ])
            ->throw()
            ->json();
    }

    public function search_nearby_veterinaries(int $radius, int $latitude, int $longitude)
    {
        return Http::get("https://maps.googleapis.com/maps/api/place/findplacefromtext/json", [
            "radius" => $radius,
            "key" => $this->api_token,
            "location" => "{$latitude}, {$longitude}",
            "inputtype" => "textquery",
            "locationbias" => [
                "circle:" => "{$radius}@{$latitude}{$longitude}"
            ]
        ])
            ->throw()
            ->json();
    }
}
