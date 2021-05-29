<?php

namespace App\Http\Livewire;

use App\Models\MaintenanceFee;
use Form;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MaintenanceFeeCreate extends Component
{
    use AuthorizesRequests;

    public string $form_method = "saveMaintenanceFee";
    public string $card_title = "create maintenance record";

    public string $reason = "";
    public string $farm_id = "";
    public string $expense_amount = "";
    public string $date_of_incident = "";

    protected function getRules()
    {
        return [
            "reason" => ["string", "required"],
            "expense_amount" => ["integer", "required"],
            "farm_id" => ["required", "exists:App\Models\Farm,id"],
            "date_of_incident" => ["date", "required", "before:" . now()],
        ];
    }

    public function mount()
    {
        $farm_id = auth()->user()->farm->id;

        $this->fill([
            "farm_id" => $farm_id,
        ]);
    }

    public function saveMaintenanceFee()
    {
//        $this->authorize();
        $validated = $this->validate();

        try {
            MaintenanceFee::create($validated);
            session()->flash("success", "Successfully created maintenanace record");

            $this->reset(
                "reason",
                "expense_amount",
                "date_of_incident",
            );
        } catch (\Exception $e) {
            session()->flash("error", "Something went wrong");
        }
    }

    public function render()
    {
        $inputs = [
            "fields" => [
                "reason" => [
                    "label" => Form::label("Reason"),
                    "input" => Form::text("reason", null, ["wire:model" => "reason"])
                ],
                "expense_amount" => [
                    "label" => Form::label("Expense amount"),
                    "input" => Form::number("expense_amount", null, ["wire:model" => "expense_amount", "min" => 0])
                ],
                "date_of_incident" => [
                    "label" => Form::label("Date of incident"),
                    "input" => Form::date("date_of_incident", null, ["wire:model" => "date_of_incident"])
                ],
            ],
            "form_bottom_buttons" => [
                "submit" => Form::submit("Create"),
            ]
        ];

        return view('livewire.maintenance-fee-create', compact("inputs"));
    }
}
