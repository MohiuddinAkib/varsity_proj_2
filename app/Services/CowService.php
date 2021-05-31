<?php


namespace App\Services;

use App\Models\Cow;
use App\Contract\ICowService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class CowService implements ICowService
{
    public function create(int $breed_id, string|int $farm_id, int $weight, string $gender, string $description, string $dob, string $type): Cow
    {
        $input = compact("weight","description", "breed_id", "farm_id", "dob", "gender", "type");
        return Cow::create($input);
    }

    public function update(int $cow_id, int $breed_id, int $farm_id, string $gender, string $description, string $dob, string $type): Cow
    {
        $input = compact("description", "breed_id", "farm_id", "dob", "gender", "type");

        $cow = Cow::findOrFail($cow_id);
        $cow->update($input);

        return $cow;
    }
}
