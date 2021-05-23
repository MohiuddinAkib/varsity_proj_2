<?php

namespace App\Http\Livewire\Superadmin;

use Farm;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use App\Models\Farm as FarmModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FarmList extends Component
{
    use AuthorizesRequests, WithFileUploads;

    /**
     * @var string $name
     */
    public $name;
    /**
     * @var string $city
     */
    public $city;
    /**
     * @var string $area
     */
    public $area;
    /**
     * @var UploadedFile $image
     */
    public $image;
    /**
     * @var string $region
     */
    public $region;
    /**
     * @var string $address
     */
    public $address;
    /**
     * @var string $imagePath
     */
    public $imagePath;
    /**
     * @var string|null $closed_at
     */
    public $closed_at;
    /**
     * @var string $established_at
     */
    public $established_at;

    public $modalMode;

    /**
     * @var boolean $openModal
     */
    public $openModal = false;


    protected $rules = [
        "name" => "required",
        "city" => "required",
        "area" => "required",
        "address" => "required",
        "region" => "required",
        "image" => "required|image|max:1024",
        "closed_at" => "nullable|date|after:established_at",
        "established_at" => "required|date|before:closed_at",
    ];

    public function createFarm()
    {
        $this->authorize("create", FarmModel::class);
        $this->validate();

        $created = Farm::create(
            $this->name,
            $this->city,
            $this->area,
            $this->address,
            $this->region,
            $this->established_at,
            $this->closed_at,
            $this->image
        );

        if ($created) {
            session()->flash("success", "Farm created successfully");
        } else {
            session()->flash("error", "Farm was not created");
        }
    }

    public function render()
    {
        return view("livewire.superadmin.farm");
    }
}
