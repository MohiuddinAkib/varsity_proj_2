<?php

namespace App\Contract;

interface ICowService
{
    const MALE = "male";
    const FEMALE = "female";
    const TYPE_DAIRY = "dairy";
    const TYPE_FATTENING = "fattening";

    public function create(string $name, int $breed_id, int $farm_id, string $gender, string $description, string $dob, string $type);

    public function update(int $cow_id, string $name, int $breed_id, int $farm_id, string $gender, string $description, string $dob, string $type);
}
