<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FarmList extends Component
{
    public string $page_title = "Farm list";

    public function render()
    {
        return view('livewire.farm-list');
    }
}
