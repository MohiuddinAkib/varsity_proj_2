<?php

namespace App\Http\Livewire;

use User;
use Form;
use Livewire\Component;
use App\Contract\IUserRole;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeCreate extends Component
{
    use AuthorizesRequests;

    public string $form_method = "saveUser";
    public string $card_title = "create employee";

    public array $roles = [];
    public string $name = "";
    public int $salary_figure = 0;
    public string $join_date = "";
    public string $position = "";
    public string $contact_number = "";
    public string $current_address = "";
    public string $permanent_address = "";

    protected function getRules()
    {
        return [
            "name" => ["string", "required"],
            "salary_figure" => ["integer", "min:0"],
            "current_address" => ["string", "required",],
            "permanent_address" => ["string", "required",],
            "contact_number" => ["required", "min:11", "max:14"],
            "join_date" => ["date", "required", "before:" . now()],
            "position" => ["required", "exists:Spatie\Permission\Models\Role,id"],
        ];
    }

    public function mount()
    {
        $roles = Role::whereNotIn("name", [IUserRole::HOST_ADMIN, IUserRole::EMPLOYEE, IUserRole::LOCAL_ADMIN, IUserRole::SUPER_ADMIN])->get();
        $roles = $roles->mapWithKeys(fn($item) => [$item["id"] => $item["name"]])->toArray();

        $this->fill([
            "roles" => $roles,
            "position" => array_key_first($roles)
        ]);
    }

    public function saveUser()
    {
//        $this->authorize();
        $this->validate();

        try {
            User::createEmployee($this->name, $this->contact_number, $this->permanent_address, $this->current_address, $this->position, auth()->user()->farm->id, $this->salary_figure, $this->join_date);
            session()->flash("success", "Successfully created employee");

            $this->reset(
                "name",
                "salary_figure",
                "current_address",
                "permanent_address",
                "contact_number",
                "join_date",
                "position",
            );
        } catch (\Exception $e) {
            session()->flash("error", "Something went wrong");
        }
    }

    public function render()
    {
        $inputs = [
            "fields" => [
                "name" => [
                    "label" => Form::label("Name"),
                    "input" => Form::text("name", $this->name, ["wire:model" => "name"]),
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
                "position" => [
                    "label" => Form::label("Select Position"),
                    "input" => Form::select("position", $this->roles, null, ["wire:model" => "position"])
                ],
            ],
            "form_bottom_buttons" => [
                "submit" => Form::submit("Create"),
            ]
        ];

        return view('livewire.employee-create', compact("inputs"));
    }
}
