<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CowRecordList extends Component
{
    public string $page_title = "Cow Record";

    public function render()
    {
        return view('livewire.cow-record-list');
    }
}
