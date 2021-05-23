<?php

namespace App\Contract;

interface IFarmService
{
    public function assignLocalAdmin(int $farm_id, int $user_id);

    public function removeLocalAdmin(int $farm_id);

    public function create(string $name, string $location, int $owner_id, string $establish_date, int|null $ladmin_id);
}
