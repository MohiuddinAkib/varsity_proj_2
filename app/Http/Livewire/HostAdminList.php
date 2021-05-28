<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HostAdminList extends Component
{
    public string $page_title = "Host admin";

    public function render()
    {
        return view('livewire.host-admin-list');
    }
}
