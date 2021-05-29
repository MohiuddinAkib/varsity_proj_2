<?php

namespace App\Http\Livewire;

use Map;
use Livewire\Component;

class SearchVeterianry extends Component
{

    public ?int $radius = null;
    public ?int $latitude = null;
    public ?int $longitude = null;
    public bool $is_loading = false;
    public array $search_results = [];

    public function mount()
    {
        $farm = auth()->user()->farm;
        $latitude = $farm->latitude;
        $longitude = $farm->longitude;

        $this->fill([
            "latitude" => $latitude,
            "longitude" => $longitude,
        ]);
    }

    public function fetchNearByVeterinaries()
    {
        if (!is_null($this->radius)) {
            $this->is_loading = true;
            try {
                Map::search_nearby_veterinaries($this->radius, $this->latitude, $this->longitude);

            } catch (\Exception $e) {
                dd($e->getMessage());
            } finally {
                $this->is_loading = false;
            }
        }
    }

    public function render()
    {

        return view('livewire.search-veterianry');
    }
}
