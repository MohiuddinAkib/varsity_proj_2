<?php

namespace App\Http\Livewire;

use Form;
use App\Models\Cow;
use Livewire\Component;
use App\Models\HealthCondition;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HealthConditionCreate extends Component
{
    use AuthorizesRequests;

    public string $form_method = "saveHealthConditionRecord";
    public string $card_title = "create health cond record";

    public array $cows = [];

    public string $note = "";
    public string $cow_id = "";
    public string $condition = "";

    protected function getRules()
    {
        return [
            "cow_id" => ["required", "exists:App\Models\Cow,id"],
            "condition" => ["required", "string", Rule::in(["good", "bad"])],
            "note" => ["nullable", "string"],
        ];
    }

    public function mount()
    {
        $farm_id = auth()->user()->farm->id;
        $cows = Cow::whereFarmId($farm_id)->get();
        $cows = $cows->mapWithKeys(fn($item) => [$item["id"] => $item["name"]])->toArray();

        $this->fill([
            "cows" => $cows,
            "cow_id" => array_key_first($cows),
            "condition" => "good",
        ]);
    }

    public function saveHealthConditionRecord()
    {
//        $this->authorize();
        $validated = $this->validate();


        try {
            HealthCondition::create($validated);
            session()->flash("success", "Successfully created health condition");

            $this->reset(
                "condition",
                "note",
            );
        } catch (\Exception $e) {
            session()->flash("error", "Something went wrong");
        }
    }

    public function render()
    {
        $inputs = [
            "fields" => [
                "cow_id" => [
                    "label" => Form::label("Cow serial"),
                    "input" => Form::select("cow_id", $this->cows, null, ["wire:model" => "cow_id"])
                ],
                "condition" => [
                    "label" => Form::label("Condition"),
                    "input" => Form::select("condition", ["good" => "Good", "bad" => "Bad"], null, ["wire:model" => "condition", "min" => 0])
                ],
                "note" => [
                    "label" => Form::label("Note"),
                    "input" => Form::text("note", null, ["wire:model" => "note"])
                ],
            ],
            "form_bottom_buttons" => [
                "submit" => Form::submit("Create"),
            ]
        ];

        return view('livewire.health-condition-create', compact("inputs"));
    }
}
