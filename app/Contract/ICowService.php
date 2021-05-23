<?php

namespace App\Contract;

use App\Models\Cow;
use App\Models\Farm;
use App\Models\Breed;
use App\Services\CowService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

interface ICowService
{
    const MALE = 0;
    const FEMALE = 1;

    const FARM_COW_IMAGE_DIR = "farms/cows";
    const FARM_COW_IMAGE_DISK = "public";

    /**
     * @param string $name
     * @param Breed|int $breed_id
     * @param Farm|int $farm_id
     * @param int $gender
     * @param UploadedFile $image
     * @param string $description
     * @param $dob
     * @param string $extras
     * @return bool
     */
    public function create(string $name, $breed_id, $farm_id, int $gender, UploadedFile $image, string $description, $dob, string $extras);

    /**
     * @param string $name
     * @param Breed|int $breed_id
     * @param Farm|int $farm_id
     * @param int $gender
     * @param UploadedFile $image
     * @param string $description
     * @param $dob
     * @param string $extras
     * @return bool
     */
    public function update(string $name, $breed_id, $farm_id, int $gender, UploadedFile $image, string $description, $dob, string $extras);

    /**
     * @param Cow|int $cow
     * @return ICowService
     */
    public function forCow($cow);
}
