<?php


namespace App\Services;

use App\Models\Farm;
use App\Models\User;
use App\Contract\IFarmService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

class FarmService implements IFarmService
{
    /**
     * @var Farm|null $farm
     */
    public $farm;

    /**
     * @var string $imagePath
     */
    public $imagePath;

    /**
     * @param Farm|int $farm
     * @return IFarmService
     */
    public function forFarm($farm)
    {
        $this->farm = $farm;

        if (is_int($this->farm)) {
            $this->farm = Farm::findOrFail($this->farm);
        }

        return $this;
    }

    /**
     * @return Farm|null
     */
    public function getFarmModelInstance()
    {
        return $this->farm;
    }

    /**
     * @param User|int $user
     * @return boolean
     */
    public function assignLocalAdmin($user)
    {
        if (is_null($this->farm)) {
            return false;
        }

        if (is_int($user)) {
            $user = User::findOrFail($user);
        }

        $this->farm->localAdmin->removeRole("localadmin");

        $user->assignRole("localadmin");

        return true;
    }

    /**
     * @return boolean
     */
    public function removeLocalAdmin()
    {
        if (is_null($this->farm)) {
            return false;
        }

        $this->farm->localAdmin->removeRole("localadmin");

        return true;
    }

    /**
     * @param string $name
     * @param string $city
     * @param string $area
     * @param string $address
     * @param string $region
     * @param DateTime|string $established_at
     * @param DateTime|string|null $closed_at
     * @param UploadedFile $image
     */
    public function create(string $name, string $city, string $area, string $address, string $region, $established_at, $closed_at, UploadedFile $image)
    {
        $input = compact("name", "city", "area", "address", "region", "established_at", "closed_at", "image");

        $validator = Validator::make($input, [
            "name" => "required|string",
            "city" => "required|string",
            "area" => "required|string",
            "address" => "required|string",
            "region" => "required|string",
            "image" => "required|image|max:1024",
            "closed_at" => "nullable|date|after:established_at",
            "established_at" => "required|date|before:closed_at",
        ]);

        if ($validator->fails()) {
            return false;
        }

        $farm = Farm::create($validator->validated());
        $this->imagePath = $image->store(self::FARM_IMAGE_DIR, self::FARM_IMAGE_DISK);

        $farm->image()->create([
            "url" => $this->imagePath
        ]);

        return true;
    }
}
