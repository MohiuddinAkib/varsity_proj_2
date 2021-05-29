<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HealthConditionList extends Component
{
    public string $page_title = "Health condition";

    public function render()
    {
        return view('livewire.health-condition-list');
    }
}
