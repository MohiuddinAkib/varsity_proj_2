<?php

namespace Tests\Feature;

use Farm;
use App\Models\User;
use App\Contract\IFarmService;
use App\Models\Farm as FarmModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseCount;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses()->group("FarmsService");

test("validate input", function () {
    Storage::fake(IFarmService::FARM_IMAGE_DISK);
    $file = UploadedFile::fake()->image("avatar.jpg");
    $created = Farm::create($name = faker()->name,
        "",
        "",
        "",
        "",
        "",
        "", $file);

    expect($created)->toBeFalse();

    assertDatabaseCount("farms", 0);
});

test("Can create a farm", function () {
    Storage::fake(IFarmService::FARM_IMAGE_DISK);
    $file = UploadedFile::fake()->image("avatar.jpg");

    $created = Farm::create($name = faker()->name,
        $city = faker()->city,
        $area = faker()->areaCode,
        $address = faker()->address,
        $region = faker()->streetAddress,
        $established_at = faker()->dateTimeBetween(),
        "", $file);

    expect($created)->toBeTrue();
    Storage::disk(IFarmService::FARM_IMAGE_DISK)->assertExists($file->hashName(IFarmService::FARM_IMAGE_DIR));
    assertDatabaseHas("farms", [
        "name" => $name,
        "city" => $city,
        "area" => $area,
        "address" => $address,
        "region" => $region,
    ]);
});

test("Can assign a local admin", function () {
    $la = createLocalAdmin();
    $employee = User::factory()->create();
    $employee->assignRole("employee");

    $farm = FarmModel::factory()->create();
    $farm->employees()->save($la);
    $farm->employees()->save($employee);

    expect($farm->employees)->toBeObject();
    expect($farm->employees->toArray())->toHaveCount(2);

    expect($la->farm_id)->toEqual($farm->id);
    expect($la->hasRole("localadmin"))->toBeTrue();
    expect($employee->farm_id)->toEqual($farm->id);
    expect($farm->localadmin->name)->toBe($la->name);
    expect(User::role('localadmin')->first()->farm_id)->toEqual($farm->id);

    Farm::forFarm($farm)->assignLocalAdmin($employee);

    $la->refresh();
    expect($la->hasRole("localadmin"))->toBeFalse();
    expect($employee->hasRole("localadmin"))->toBeTrue();
});

test("Remove a local admin", function () {
    $la = createLocalAdmin();

    $farm = FarmModel::factory()->create();
    $farm->employees()->save($la);

    expect($farm->employees)->toBeObject();
    expect($farm->employees->toArray())->toHaveCount(1);


    expect($la->farm_id)->toEqual($farm->id);
    expect($la->hasRole("localadmin"))->toBeTrue();
    expect($farm->localadmin->name)->toBe($la->name);
    expect(User::role('localadmin')->first()->farm_id)->toEqual($farm->id);

    Farm::forFarm($farm)->removeLocalAdmin();

    $la->refresh();
    expect($la->hasRole("localadmin"))->toBeFalse();
});
