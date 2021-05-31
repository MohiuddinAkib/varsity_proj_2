<?php

namespace App\Http\Livewire;

use App\Models\Farm;
use User;
use Form;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LocalAdminCreate extends Component
{
    use AuthorizesRequests;

    public string $form_method = "saveUser";
    public string $card_title = "create local admin";

    public string $name = "";
    public string $email = "";
    public string $farm_id = "";
    public string $password = "";
    public int $salary_figure = 0;
    public string $join_date = "";
    public string $contact_number = "";
    public string $current_address = "";
    public string $permanent_address = "";
    public string $password_confirmation = "";

    protected function getRules()
    {
        return [
            "name" => ["string", "required"],
            "salary_figure" => ["integer", "min:0"],
            "current_address" => ["string", "required",],
            "permanent_address" => ["string", "required",],
            "email" => ["email", "required", "unique:users"],
            "contact_number" => ["required", "min:11", "max:14"],
            "join_date" => ["date", "required", "before:" . now()],
            "farm_id" => ["required", "exists:App\Models\Farm,id"],
            "password" => ["string", "required", "min:8", "confirmed"],
        ];
    }

    public function saveUser()
    {
//        $this->authorize();
        $this->validate();

        try {
            User::createLocalAdmin($this->name, $this->email, $this->password, $this->contact_number, $this->permanent_address, $this->current_address, $this->farm_id, $this->salary_figure, $this->join_date);
            session()->flash("success", "Successfully created host admin");

            $this->reset(
                "name",
                "email",
                "password",
                "password_confirmation",
                "salary_figure",
                "current_address",
                "permanent_address",
                "contact_number",
                "join_date",
                "farm_id",
            );
        } catch (\Exception $e) {
            session()->flash("error", "Something went wrong");
        }
    }

    public function render()
    {
        $farm_list = Farm::whereOwnerId(auth()->id())->get();
        $farm_list = $farm_list->mapWithKeys(fn($item) => [$item["id"] => $item["name"]])->toArray();
        $this->farm_id = array_key_first($farm_list);

        $inputs = [
            "fields" => [
                "name" => [
                    "label" => Form::label("Name"),
                    "input" => Form::text("name", $this->name, ["wire:model" => "name"]),
                ],
                "email" => [
                    "label" => Form::label("Email Address"),
                    "input" => Form::email("email", $this->email, ["wire:model" => "email"])
                ],
                "password" => [
                    "label" => Form::label("Password"),
                    "input" => Form::password("password", ["wire:model" => "password"])
                ],
                "password_confirmation" => [
                    "label" => Form::label("Confirm Passowrd"),
                    "input" => Form::password("password_confirmation", ["wire:model" => "password_confirmation"])
                ],
                "permanent_address" => [
                    "label" => Form::label("Permanent Address"),
                    "input" => Form::text("permanent_address", null, ["wire:model" => "permanent_address"])
                ],
                "current_address" => [
                    "label" => Form::label("Current Address"),
                    "input" => Form::text("current_address", null, ["wire:model" => "current_address"])
                ],
                "contact_number" => [
                    "label" => Form::label("Contact Number"),
                    "input" => Form::text("contact_number", null, ["wire:model" => "contact_number"])
                ],
                "join_date" => [
                    "label" => Form::label("Join Date"),
                    "input" => Form::date("join_date", null, ["wire:model" => "join_date"])
                ],
                "salary_figure" => [
                    "label" => Form::label("Salary Figure"),
                    "input" => Form::number("salary_figure", null, ["wire:model" => "salary_figure", "min" => 0])
                ],
                "farm_id" => [
                    "label" => Form::label("Select Farm"),
                    "input" => Form::select("farm_id", $farm_list, null, ["wire:model" => "farm_id"])
                ],
            ],
            "form_bottom_buttons" => [
                "submit" => Form::submit("Create"),
            ]
        ];

        return view('livewire.local-admin-create', [
            "inputs" => $inputs,
        ]);
    }
}
