<?php

namespace App\Contract;

use App\Models\Farm;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

interface IPostService
{
    const FARM_POST_IMAGE_DIR = "farms/posts";
    const FARM_POST_IMAGE_DISK = "public";

    /**
     * @param Post|int $post
     * @return \App\Contract\IPostService
     */
    public function forPost($post);

    /**
     * @param string $title
     * @param string $body
     * @param UploadedFile &$image
     * @param \App\Models\Farm|int $farm_id
     * @param User|int $op
     * @return bool
     */
    public function create(string $title, string $body, UploadedFile &$image, $farm_id, $op);
}
