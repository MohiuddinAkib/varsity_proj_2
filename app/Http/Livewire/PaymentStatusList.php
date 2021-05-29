<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PaymentStatusList extends Component
{
    public string $page_title = "Payment status";

    public function render()
    {
        return view('livewire.payment-status-list');
    }
}
