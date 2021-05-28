<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LocalAdminList extends Component
{
    public string $page_title = "Local Admin";
    public function render()
    {
        return view('livewire.local-admin-list');
    }
}
