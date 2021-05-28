<?php

namespace App\Http\Livewire;

use App\Facades\Farm;
use Form;
use App\Models\User;
use Livewire\Component;
use App\Contract\IUserRole;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FarmCreate extends Component
{
    use AuthorizesRequests;

    public string $form_method = "saveUser";
    public string $card_title = "create farm";

    public string $name = "";
    public string $location = "";
    public string $owner_id = "";
    public ?string $ladmin_id = null;
    public string $contact_number = "";
    public string $establish_date = "";

    protected function getRules()
    {
        return [
            "name" => ["string", "required"],
            "location" => ["string", "required"],
            "owner_id" => ["required", "exists:App\Models\User,id"],
            "ladmin_id" => ["nullable", "exists:App\Models\User,id"],
            "establish_date" => ["date", "required", "before:" . now()],
            "contact_number" => ["string", "nullable", "min:11", "max:14"],
        ];
    }

    protected function getMessages()
    {
        return [
            "location.required" => "Farm location field is required"
        ];
    }

    public function mount()
    {
        $this->fill([
            "owner_id" => auth()->id(),
        ]);
    }

    public function saveUser()
    {

//        $this->authorize();
        $this->validate();

        try {
            Farm::create($this->name, $this->location, $this->owner_id, $this->establish_date, $this->ladmin_id);
            session()->flash("success", "Successfully created host admin");

            $this->reset(
                "name",
                "location",
                "contact_number",
                "owner_id",
                "establish_date",
            );
        } catch (\Exception $e) {
            session()->flash("error", "Something went wrong");
        }
    }

    public function render()
    {
        $local_admins = User::role(IUserRole::EMPLOYEE)->get(["id", "name"]);
        $local_admins = $local_admins->mapWithKeys(fn($item) => [$item["id"] => $item["name"]])->toArray();

        $inputs = ([
            "fields" => [
                "name" => [
                    "label" => Form::label("Name"),
                    "input" => Form::text("name", $this->name, ["wire:model" => "name"])
                ],
                "location" => [
                    "label" => Form::label("Farm Location"),
                    "input" => Form::text("location", $this->location, ["wire:model" => "location"])
                ],
                "ladmin_id" => [
                    "label" => Form::label("Local Admin"),
                    "input" => Form::select("ladmin_id", $local_admins, null, ["wire:model" => "ladmin_id"])
                ],
                "contact_number" => [
                    "label" => Form::label("Contact Number"),
                    "input" => Form::text("contact_number", $this->contact_number, ["wire:model" => "contact_number"])
                ],
                "establish_date" => [
                    "label" => Form::label("Establish date"),
                    "input" => Form::date("establish_date", $this->establish_date, ["wire:model" => "establish_date"])
                ]
            ],
            "form_bottom_buttons" => [
                "submit" => Form::submit("Create"),
            ]
        ]);

        return view('livewire.farm-create', [
            "inputs" => $inputs,
        ]);
    }
}
