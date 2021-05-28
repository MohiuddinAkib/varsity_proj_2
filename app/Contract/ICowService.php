<?php

namespace App\Contract;

use App\Models\Cow;

interface ICowService
{
    const MALE = "male";
    const FEMALE = "female";
    const TYPE_DAIRY = "dairy";
    const TYPE_FATTENING = "fattening";

    public function create(int $breed_id, int $farm_id, string $gender, string $description, string $dob, string $type): Cow;

    public function update(int $cow_id, int $breed_id, int $farm_id, string $gender, string $description, string $dob, string $type): Cow;
}
