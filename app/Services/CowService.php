<?php


namespace App\Services;

use App\Models\Cow;
use App\Models\Farm;
use App\Models\Breed;
use App\Contract\ICowService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;


class CowService implements ICowService
{
    /**
     * @var Cow $cow
     */
    public $cow;

    /**
     * @var string $imagePath
     */
    public $imagePath;


    /**
     * @param Cow|int $cow
     * @return ICowService
     */
    public function forCow($cow)
    {
        $this->cow = $cow;
        if (is_int($this->cow)) {
            $this->post = Cow::findOrFail($this->post);
        }
        return $this;
    }

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
    public function create(string $name, $breed_id, $farm_id, int $gender, UploadedFile $image, string $description, $dob, string $extras)
    {
        if (!is_int($breed_id)) {
            $breed_id = $breed_id->id;
        }

        if (!is_int($farm_id)) {
            $farm_id = $farm_id->id;
        }

        $input = compact("name", "image", "description", "breed_id", "farm_id", "dob", "extras", "gender");

        $validator = Validator::make($input, [
            "name" => "required|string",
            "extras" => "nullable|string",
            "description" => "required|string",
            "image" => "required|image|max:1024",
            "dob" => 'required|date|before:tomorrow',
            "farm_id" => "required|exists:App\Models\Farm,id",
            "breed_id" => "required|exists:App\Models\Breed,id",
            "gender" => ["required", "integer", Rule::in([ICowService::MALE, ICowService::FEMALE])],
        ]);

        if ($validator->fails()) {
            return false;
        }

        $cow = Cow::create($validator->validated());
        $this->imagePath = $image->store(self::FARM_COW_IMAGE_DIR, self::FARM_COW_IMAGE_DISK);

        $cow->image()->create([
            "url" => $this->imagePath
        ]);

        return true;
    }


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
    public function update(string $name, $breed_id, $farm_id, int $gender, UploadedFile $image, string $description, $dob, string $extras)
    {
        if (!is_int($breed_id)) {
            $breed_id = $breed_id->id;
        }

        if (!is_int($farm_id)) {
            $farm_id = $farm_id->id;
        }

        $input = compact("name", "image", "description", "breed_id", "farm_id", "dob", "extras", "gender");

        $validator = Validator::make($input, [
            "name" => "required|string",
            "extras" => "nullable|string",
            "description" => "required|string",
            "image" => "required|image|max:1024",
            "dob" => 'required|date|before:tomorrow',
            "farm_id" => "required|exists:App\Models\Farm,id",
            "breed_id" => "required|exists:App\Models\Breed,id",
            "gender" => ["required", "integer", Rule::in([ICowService::MALE, ICowService::FEMALE])],
        ]);

        if ($validator->fails()) {
            return false;
        }

        $previousImagePath = $this->cow->image->url;
        $this->cow->update($validator->validated());
        Storage::disk(ICowService::FARM_COW_IMAGE_DISK)->delete($previousImagePath);
        $this->imagePath = $image->store(self::FARM_COW_IMAGE_DIR, self::FARM_COW_IMAGE_DISK);
        $this->cow->image()->update([
            "url" => $this->imagePath
        ]);
        return true;
    }
}
