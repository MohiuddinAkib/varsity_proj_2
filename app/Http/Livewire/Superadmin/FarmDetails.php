<?php

namespace App\Http\Livewire\Superadmin;

use Farm;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Farm as FarmModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FarmDetails extends Component
{
    use AuthorizesRequests;

    /**
     * @var FarmModel
     */
    public $farm;

    public function mount(FarmModel $farm)
    {
        $this->farm = $farm;
    }

    public function assignLocalAdmin(User $user)
    {
        $this->authorize("update-farm-local-admin");

        $assigned = Farm::forFarm($this->farm)->assignLocalAdmin($user);

        if ($assigned) {
            session()->flash("success", "Successfully assigned localadmin");
        } else {
            session()->flash("error", "Localadmin was not assigned");
        }
    }

    public function removeLocalAdmin()
    {
        $this->authorize("update-farm-local-admin");

        $removed = Farm::forFarm($this->farm)->removeLocalAdmin();

        if ($removed) {
            session()->flash("success", "Successfully removed localadmin");
        } else {
            session()->flash("error", "Localadmin could not be removed");
        }
    }

    public function importEmployees()
    {

    }

    public function render()
    {
        return view('livewire.superadmin.farm-details');
    }
}
