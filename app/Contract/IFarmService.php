<?php

namespace App\Contract;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Http\UploadedFile;

interface IFarmService
{
    const FARM_IMAGE_DIR = "farms";
    const FARM_IMAGE_DISK = "public";

    /**
     * @param Farm|int $farm
     * @return IFarmService
     */
    public function forFarm($farm);

    /**
     * @return Farm|null
     */
    public function getFarmModelInstance();

    /**
     * @param User|int $user
     * @return boolean
     */
    public function assignLocalAdmin($user);

    /**
     * @return boolean
     */
    public function removeLocalAdmin();

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
    public function create(string $name, string $city, string $area, string $address, string $region, string $established_at, string $closed_at, UploadedFile $image);
}
