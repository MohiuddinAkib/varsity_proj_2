<?php

namespace App\Http\Livewire;

use User;
use Form;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HostAdminCreate extends Component
{
    use AuthorizesRequests;

    public string $form_method = "saveUser";
    public string $card_title = "create host admin";

    public string $name = "";
    public string $email = "";
    public string $password = "";
    public string $password_confirmation = "";

    protected function getRules()
    {
        return [
            "name" => ["string", "required"],
            "email" => ["email", "required", "unique:users"],
            "password" => ["string", "required", "min:8", "confirmed"],
        ];
    }

    public function saveUser()
    {
//        $this->authorize();
        $this->validate();

        try {
            User::createHostAdmin($this->name, $this->email, $this->password, null, null, null);
            session()->flash("success", "Successfully created host admin");

            $this->reset(
                "name",
                "email",
                "password",
                "password_confirmation"
            );
        } catch (\Exception $e) {
            session()->flash("error", "Something went wrong");
        }
    }

    public function render()
    {
        $inputs = ([
            "fields" => [
                "name" => [
                    "label" => Form::label("Name"),
                    "input" => Form::text("name", $this->name, ["wire:model" => "name"])
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
                ]
            ],
            "form_bottom_buttons" => [
                "submit" => Form::submit("Create"),
            ]
        ]);

        return view('livewire.host-admin-create', [
            "inputs" => $inputs,
        ]);
    }
}
