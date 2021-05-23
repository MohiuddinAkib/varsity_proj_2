<?php

namespace App\Http\Livewire;

use Post;
use App\Models\Farm;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostCreate extends Component
{
    use WithFileUploads, AuthorizesRequests;

    /**
     * @var string $title
     */
    public $title;
    /**
     * @var string $body
     */
    public $body;
    /**
     * @var UploadedFile $image
     */
    public $image;

    protected $rules = [
        "title" => "string|required",
        "body" => "string|required",
        "image" => "image|required",
    ];

    public function createPost(Farm $farm, User $op)
    {
        $this->authorize("create-farm-post", $farm);
        $this->validate();

        $created = Post::create($this->title, $this->body, $this->image, $farm, $op);
        if ($created) {
            session()->flash("success", "Post was created successfully");
        } else {
            session()->flash("error", "Post was not created");
        }
    }

    public function render()
    {
        return view('livewire.post-create');
    }
}
