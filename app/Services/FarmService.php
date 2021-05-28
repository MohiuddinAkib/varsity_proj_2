<?php


namespace App\Services;

use App\Models\Farm;
use App\Models\User;
use App\Contract\IFarmService;
use Illuminate\Support\Facades\Validator;

class FarmService implements IFarmService
{

    public function assignLocalAdmin(int $farm_id, int $user_id)
    {
        $farm = Farm::findOrFail($farm_id);
        $user = User::findOrFail($user_id);

        if ($user->farm_id !== $farm_id) {
            return false;
        };

        $farm->localAdmin->removeRole("localadmin");
        $user->assignRole("localadmin");
        $farm->update([
            "contact_number" => $user->contact_number
        ]);

        return true;
    }


    public function removeLocalAdmin(int $farm_id)
    {
        $farm = Farm::findOrFail($farm_id);

        $farm->localAdmin->removeRole("localadmin");

        return true;
    }

    public function create(string $name, string $location, int $owner_id, string $establish_date, int|null $ladmin_id)
    {
        $input = compact("name", "location", "owner_id", "establish_date");

        $farm = Farm::create($input);

        if (!is_null($ladmin_id)) {
            $this->assignLocalAdmin($farm->id, $ladmin_id);
        }

        return $farm;
    }
}
