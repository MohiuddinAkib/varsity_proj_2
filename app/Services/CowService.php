<?php


namespace App\Services;

use App\Models\Cow;
use App\Contract\ICowService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class CowService implements ICowService
{
    public function create(string $name, int $breed_id, int $farm_id, string $gender, string $description, string $dob, string $type)
    {
        $input = compact("name", "description", "breed_id", "farm_id", "dob", "gender", "type");

        $validator = Validator::make($input, [
            "name" => "required|string",
            "description" => "required|string",
            "dob" => 'required|date|before:tomorrow',
            "farm_id" => "required|exists:App\Models\Farm,id",
            "breed_id" => "required|exists:App\Models\Breed,id",
            "gender" => ["required", "string", Rule::in([ICowService::MALE, ICowService::FEMALE])],
            "type" => ["required", "string", Rule::in([ICowService::TYPE_DAIRY, ICowService::TYPE_FATTENING])]
        ]);

        if ($validator->fails()) {
            return false;
        }

        Cow::create($validator->validated());

        return true;
    }

    public function update(int $cow_id, string $name, int $breed_id, int $farm_id, string $gender, string $description, string $dob, string $type)
    {
        $input = compact("name", "description", "breed_id", "farm_id", "dob", "gender", "type");

        $validator = Validator::make($input, [
            "name" => "required|string",
            "description" => "required|string",
            "dob" => 'required|date|before:tomorrow',
            "farm_id" => "required|exists:App\Models\Farm,id",
            "breed_id" => "required|exists:App\Models\Breed,id",
            "gender" => ["required", "string", Rule::in([ICowService::MALE, ICowService::FEMALE])],
            "type" => ["required", "string", Rule::in([ICowService::TYPE_DAIRY, ICowService::TYPE_FATTENING])]
        ]);

        if ($validator->fails()) {
            return false;
        }

        $cow = Cow::findOrFail($cow_id);
        $cow->update($validator->validated());

        return true;
    }
}
