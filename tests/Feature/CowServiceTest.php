<?php

use App\Models\Farm;
use App\Models\Breed;
use App\Contract\ICowService;
use App\Models\Cow as CowModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseCount;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses()->group("CowService");

/**
 * goru add krar time kon dhoroner goru seta bole dewa
 * goru ta farm_purchase naki farm_produced (kine ana hoile farm_purchase r farm er utpnoono hoile farm_produced)
 * goru ta kina hoile buying info laganu
 * produced hoile parents info laganu.
 * mark cow for sale.
 * mark cow sold after selling the cow.
 */

test("Can add a cow to a farm", function () {
    $farm = Farm::factory()->create();
    $breed = Breed::factory()->create();
    Storage::fake(ICowService::FARM_COW_IMAGE_DISK);
    $file = UploadedFile::fake()->image("avatar.jpg");

    $created = Cow::create(
        $name = faker()->name,
        $breed,
        $farm,
        $gender = ICowService::MALE,
        $file,
        $description = faker()->paragraph,
        $dob = faker()->dateTime(),
        $extras = faker()->paragraph);


    $data = compact(
        "name",
        "gender",
        "description",
        "dob",
        "extras",
    );

    $data["farm_id"] = $farm->id;
    $data["breed_id"] = $breed->id;

    expect($created)->toBeTrue();
    assertDatabaseCount("cows", 1);
    assertDatabaseHas("cows", $data);
    Storage::disk(ICowService::FARM_COW_IMAGE_DISK)->assertExists($file->hashName(ICowService::FARM_COW_IMAGE_DIR));
});

test("updating cow image will remove the previous image of the cow from disk", function () {
    $farm = Farm::factory()->create();
    $breed = Breed::factory()->create();
    Storage::fake(ICowService::FARM_COW_IMAGE_DISK);
    $file = UploadedFile::fake()->image("previous.jpg");

    $created = Cow::create(
        $name = faker()->name,
        $breed,
        $farm,
        $gender = ICowService::MALE,
        $file,
        $description = faker()->paragraph,
        $dob = faker()->dateTime(),
        $extras = faker()->paragraph);


    $data = compact(
        "name",
        "gender",
        "description",
        "dob",
        "extras",
    );

    $data["farm_id"] = $farm->id;
    $data["breed_id"] = $breed->id;

    expect($created)->toBeTrue();
    assertDatabaseCount("cows", 1);
    assertDatabaseHas("cows", $data);
    Storage::disk(ICowService::FARM_COW_IMAGE_DISK)->assertExists($file->hashName(ICowService::FARM_COW_IMAGE_DIR));

    $cow = CowModel::first();
    $newFile = UploadedFile::fake()->image("new.jpg");
    $updated = Cow::forCow($cow)->update(
        $name,
        $breed,
        $farm,
        $gender,
        $newFile,
        $description,
        $dob,
        $extras
    );

    expect($updated)->toBeTrue();
    Storage::disk(ICowService::FARM_COW_IMAGE_DISK)->assertMissing($file->hashName(ICowService::FARM_COW_IMAGE_DIR));
    Storage::disk(ICowService::FARM_COW_IMAGE_DISK)->assertExists($newFile->hashName(ICowService::FARM_COW_IMAGE_DIR));
    assertDatabaseCount("cows", 1);
    $cow->refresh();
    expect($cow->image->url)->toBe($newFile->hashName(ICowService::FARM_COW_IMAGE_DIR));
});

test("Cow can be sold", function () {

});
