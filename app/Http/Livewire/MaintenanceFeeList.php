<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MaintenanceFeeList extends Component
{
    public string $page_title = "Maintenance Fee";

    public function render()
    {
        return view('livewire.maintenance-fee-list');
    }
}
