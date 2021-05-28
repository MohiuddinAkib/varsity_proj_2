<?php

namespace App\Http\Livewire;

use Cow;
use Form;
use App\Models\Breed;
use Livewire\Component;
use App\Contract\ICowService;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CowRecordCreate extends Component
{
    use AuthorizesRequests;

    public string $form_method = "saveCow";
    public string $card_title = "create cow record";

    private array $cow_genders = [ICowService::MALE, ICowService::FEMALE];
    private array $cow_types = [ICowService::TYPE_DAIRY, ICowService::TYPE_FATTENING];

    public string $dob = "";
    public string $weight = "";
    public string $farm_id = "";
    public string $breed_id = "";
    public string $description = "";
    public string $gender = ICowService::MALE;
    public string $type = ICowService::TYPE_DAIRY;

    protected function getRules()
    {
        return [
            "weight" => ["numeric", "required", "min:1"],
            "description" => ["string", "nullable", "max:700"],
            "dob" => ["date", "required", "before:" . now()],
            "type" => ["string", "required", Rule::in($this->cow_types)],
            "breed_id" => ["string", "required", "exists:App\Models\Breed,id"],
            "gender" => ["string", "required", Rule::in($this->cow_genders)],
        ];
    }

    public function mount()
    {
        $this->fill([
            "farm_id" => auth()->user()->farm?->id ?? "", // TODO: user er farm na thakle middleware diye prevent krbo
        ]);
    }

    public function saveCow()
    {
//        $this->authorize("create", Cow::class);
        $this->validate();

        try {
            $cow = Cow::create($this->breed_id, $this->farm_id, $this->gender, $this->description, $this->dob, $this->type);
            session()->flash("success", "Successfully created organization");
            $this->reset(
                "breed_id",
                "weight",
                "type",
                "gender",
                "description",
                "dob",
            );
        } catch (\Exception $e) {
            dd($e->getMessage());
            session()->flash("error", "Something went wrong");
        }
    }

    public function render()
    {
        $breeds = Breed::all("id", "name")
            ->mapWithKeys(fn($item) => [$item["id"] => $item["name"]])
            ->toArray();

        $this->breed_id = (string)array_key_first($breeds);

        $inputs = collect([
            "fields" => [
                "breed_id" => [
                    "label" => Form::label("Breed"),
                    "input" => Form::select("breed_id", $breeds, null, ["wire:model" => "breed_id"])
                ],
                "weight" => [
                    "label" => Form::label("Weight"),
                    "input" => Form::number("weight", $this->weight, ["wire:model" => "weight", "min" => 1])
                ],
                "type" => [
                    "label" => Form::label("Type"),
                    "input" => Form::select("type", [ICowService::TYPE_DAIRY => "Dairy", ICowService::TYPE_FATTENING => "Fattening"], null, ["wire:model" => "type"])
                ],
                "gender" => [
                    "label" => Form::label("gender"),
                    "input" => Form::select("gender", [ICowService::MALE => "Male", ICowService::FEMALE => "Female"], null, ["wire:model" => "gender"])
                ],
                "description" => [
                    "label" => Form::label("Description"),
                    "input" => Form::textarea("description", $this->description, ["wire:model" => "description"])
                ],
                "dob" => [
                    "label" => Form::label("Date of birth"),
                    "input" => Form::date("dob", $this->dob, ["wire:model" => "dob"])
                ],
            ],
            "form_bottom_buttons" => [
                "submit" => Form::submit("Create"),
            ]
        ]);

        return view('livewire.cow-record-create', [
            "inputs" => $inputs,
        ]);
    }
}
