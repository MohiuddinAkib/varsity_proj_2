<?php

namespace Tests\Feature;

use Post;
use App\Models\Farm;
use App\Models\User;
use App\Contract\IPostService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses()->group("PostService");

test("Can create a post for a farm's employees", function () {
    $op = User::factory()->create();
    $farm = Farm::factory()->create();

    Storage::fake(IPostService::FARM_POST_IMAGE_DISK);
    $file = UploadedFile::fake()->image("avatar.jpg");

    $created = Post::create($title = faker()->title, $body = faker()->paragraph, $file, $farm, $op->id);

    expect($created)->toBeTrue();
    Storage::disk(IPostService::FARM_POST_IMAGE_DISK)->assertExists($file->hashName(IPostService::FARM_POST_IMAGE_DIR));
});
