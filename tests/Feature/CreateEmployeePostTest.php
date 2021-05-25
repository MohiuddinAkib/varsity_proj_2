<?php

namespace Tests\Feature;

use App\Models\Farm;
use App\Models\Image;
use App\Contract\IPostService;
use App\Http\Livewire\PostCreate;
use Illuminate\Http\UploadedFile;
use function Pest\Livewire\livewire;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\assertDatabaseCount;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses()->group("Farm User Management For Employees");

test("Non superadmin or non localadmin is forbidden to create post", function () {
    $employee = actingAsEmployee();

    $farm = Farm::factory()->create();
    $farm->employees()->save($employee);

    Storage::fake("public");
    $file = UploadedFile::fake()->image("avatar.jpg");

    livewire(PostCreate::class)
        ->set("image", $file)
        ->set("title", $title = faker()->title)
        ->set("body", $body = faker()->paragraph)
        ->call("createPost", $farm, $employee->id)
        ->assertForbidden();
});

test("Should validate input", function () {
    $auth = actingAsSuperAdmin();

    $farm = Farm::factory()->create();

    livewire(PostCreate::class)
        ->set("image", "helllo")
        ->set("body", "")
        ->set("title", "")
        ->call("createPost", $farm, $auth->id)
        ->assertHasErrors(["title" => "required", "body" => "required", "image" => "image"]);

});

test("Superadmin can create a post for a farm's employees", function () {
    $auth = actingAsSuperAdmin();
    $farm = Farm::factory()->create();

    Storage::fake(IPostService::FARM_POST_IMAGE_DISK);
    $file = UploadedFile::fake()->image("avatar.jpg");

    livewire(PostCreate::class)
        ->set("image", $file)
        ->set("title", $title = faker()->title)
        ->set("body", $body = faker()->paragraph)
        ->call("createPost", $farm, $auth->id)
        ->assertOk();

    assertDatabaseCount("posts", 1);
    $postImage = Image::first();
    Storage::disk(IPostService::FARM_POST_IMAGE_DISK)->assertExists($postImage->url);
    expect($farm->posts->first()->image->url)->toBe($postImage->url);
});

test("Localadmin can create a post for a farm's employees", function () {
    $la = actingAsLocalAdmin();
    $farm = Farm::factory()->create();
    $farm->employees()->save($la);

    Storage::fake(IPostService::FARM_POST_IMAGE_DISK);
    $file = UploadedFile::fake()->image("avatar.jpg");

    $response = livewire(PostCreate::class)
        ->set("image", $file)
        ->set("title", $title = faker()->title)
        ->set("body", $body = faker()->paragraph)
        ->call("createPost", $farm, $la->id);

    $response->assertOk();

    assertDatabaseCount("posts", 1);

    $postImage = Image::first();
    expect($farm->posts->first()->image->url)->toBe($postImage->url);
    Storage::disk(IPostService::FARM_POST_IMAGE_DISK)->assertExists($postImage->url);
});
