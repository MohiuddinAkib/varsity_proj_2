<?php


namespace App\Services;

use Farm;
use App\Models\Post;
use App\Models\User;
use App\Contract\IPostService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

class PostService implements IPostService
{
    /**
     * @var Post $post
     */
    public $post;

    /**
     * @var string $imagePath
     */
    public $imagePath;

    /**
     * @param Post|int $post
     * @return IPostService
     */
    public function forPost($post)
    {
        $this->post = $post;
        if (is_int($this->post)) {
            $this->post = Post::findOrFail($this->post);
        }
        return $this;
    }

    /**
     * @param string $title
     * @param string $body
     * @param UploadedFile &$image
     * @param \App\Models\Farm|int $farm_id
     * @param User|int $op
     * @return bool
     */
    public function create(string $title, string $body, UploadedFile &$image, $farm_id, $op)
    {
        if (!is_int($op)) {
            $op = $op->id;
        }

        if (!is_int($farm_id)) {
            $farm_id = $farm_id->id;
        }

        $input = compact("title", "body", "image", "op", "farm_id");

        $validator = Validator::make($input, [
            "title" => "string|required",
            "body" => "string|required",
            "image" => "image|required",
            "op" => "required|exists:App\Models\User,id",
            "farm_id" => "required|exists:App\Models\Farm,id",
        ]);

        if ($validator->fails()) {
            return false;
        }

        $validated = $validator->validated();

        $post = Post::create($validated);
        $this->imagePath = $image->store(self::FARM_POST_IMAGE_DIR, self::FARM_POST_IMAGE_DISK);
        $post->image()->create([
            "url" => $this->imagePath,
        ]);

        return true;
    }
}
