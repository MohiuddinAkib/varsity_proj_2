<?php

namespace App\Http\Livewire;

use App\Models\Cow;
use Livewire\Component;

class BuyZone extends Component
{

    public function render()
    {
        $cows = Cow::where("is_marked_for_sale", 1)->where("is_sold", 0)->latest()->paginate();

        return view('livewire.buy-zone', compact("cows"));
    }
}
