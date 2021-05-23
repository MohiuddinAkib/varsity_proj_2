<?php

use App\Models\User;
use App\Contract\IFarmService;
use Illuminate\Support\Carbon;
use App\Models\Farm as FarmModel;
use Illuminate\Http\UploadedFile;
use function Pest\Livewire\livewire;
use Illuminate\Support\Facades\Storage;
use App\Http\Livewire\Superadmin\FarmDetails;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{assertDatabaseCount, get};
use App\Http\Livewire\Superadmin\FarmList as FarmListComponent;

uses(RefreshDatabase::class);
uses()->group("Superadmin FarmList Management");

/**
 * @return array(
 *  "imagePath" => string,
 *  "city" => string
 *  "name" => string
 *  "area" => string
 *  "address" => string
 *  "region" => string
 *  "establishedAt" => string
 *  "closedAt" => string
 *
 * )
 */
function mockData()
{
    Storage::fake(IFarmService::FARM_IMAGE_DISK);
    $file = UploadedFile::fake()->image("avatar.jpg");

    livewire(FarmListComponent::class)
        ->set("image", $file)
        ->set("city", $city = faker()->city)
        ->set("name", $name = faker()->company)
        ->set("area", $area = faker()->streetAddress)
        ->set("address", $address = faker()->address)
        ->set("region", $region = faker()->streetName)
        ->set("established_at", $establishedAt = faker()->dateTime())
        ->set("closed_at", $closedAt = faker()->dateTimeBetween($startDate = $establishedAt, $endDate = "now", $timezone = null))
        ->call("createFarm");

    $imagePath = $file->hashName(IFarmService::FARM_IMAGE_DIR);
    return compact("imagePath", "city", "name", "area", "address", "region", "establishedAt", "closedAt");
}

test("Superadmin can create a farm", function () {
    actingAsSuperAdmin();

    livewire(FarmListComponent::class)
        ->call("createFarm")
        ->assertHasErrors([
            "name",
            "city",
            "area",
            "address",
            "region",
            "image",
        ]);

    /**
     * @var string $name
     * @var string $area
     * @var string $city
     * @var string $region
     * @var string $address
     * @var string $closedAt
     * @var string $imagePath
     * @var string $establishedAt
     */
    extract(mockData());

    assertDatabaseCount("farms", 1);
    expect(FarmModel::first()->name)->toBe($name);
    expect(FarmModel::first()->area)->toBe($area);
    expect(FarmModel::first()->city)->toBe($city);
    expect(FarmModel::first()->region)->toBe($region);
    expect(FarmModel::first()->address)->toBe($address);
    Storage::disk("public")->assertExists(FarmModel::first()->image->url);
});


test("FarmList establish date should be less than close date", function () {
    actingAsSuperAdmin();

    livewire(FarmListComponent::class)
        ->call("createFarm")
        ->assertHasErrors([
            "name",
            "city",
            "area",
            "address",
            "region",
            "image",
        ]);

    /**
     * @var string $name
     * @var string $area
     * @var string $city
     * @var string $region
     * @var string $address
     * @var string $closedAt
     * @var string $imagePath
     * @var string $establishedAt
     */
    extract(mockData());

    expect(FarmModel::first()->closed_at)->toBeInstanceOf(Carbon::class);
    expect(FarmModel::first()->established_at)->toBeInstanceOf(Carbon::class);
    expect(FarmModel::first()->established_at->lessThan(FarmModel::first()->closed_at))->toBeTrue();
});

test("non superadmin can not create a farm", function () {
    actingAsLocalAdmin();

    $response = get(route("superadmin.farm.index"));

    $response->assertForbidden();
});

test("superadmin can assign employees to a farm", function () {
    actingAsSuperAdmin();

    $la = createLocalAdmin();

    mockData();

    $farm = FarmModel::first();

    $farm->employees()->save($la);

    expect($farm->employees)->toBeObject();
    expect($farm->employees->toArray())->toHaveCount(1);


    expect($la->farm_id)->toEqual($farm->id);
    expect($farm->localadmin->name)->toBe($la->name);
    expect(User::role('localadmin')->first()->farm_id)->toEqual($farm->id);
});

test("superadmin can visit farm details page", function () {
    actingAsSuperAdmin();
    mockData();

    $farm = FarmModel::factory()->create();

    $response = get(route("superadmin.farm.show", $farm->id));
    $response->assertOk();
    $response->assertSeeLivewire("superadmin.farm-details");

    $farmDetails = livewire(FarmDetails::class, [$farm->id])->get("farm");

    expect($farmDetails->name)->toBe($farm->name);
});


test("superadmin can assign local admin to a farm", function () {
    actingAsSuperAdmin();

    $la = createLocalAdmin();
    $employee = User::factory()->create();
    $employee->assignRole("employee");

    mockData();

    $farm = FarmModel::first();
    $farm->employees()->save($la);
    $farm->employees()->save($employee);

    expect($farm->employees)->toBeObject();
    expect($farm->employees->toArray())->toHaveCount(2);


    expect($la->farm_id)->toEqual($farm->id);
    expect($la->hasRole("localadmin"))->toBeTrue();
    expect($employee->farm_id)->toEqual($farm->id);
    expect($farm->localadmin->name)->toBe($la->name);
    expect(User::role('localadmin')->first()->farm_id)->toEqual($farm->id);


    livewire(FarmDetails::class, [$farm->id])->call("assignLocalAdmin", $employee);

    $la->refresh();
    expect($la->hasRole("localadmin"))->toBeFalse();
    expect($employee->hasRole("localadmin"))->toBeTrue();
});

test("superadmin can remove local admin from a farm", function () {
    actingAsSuperAdmin();

    $la = createLocalAdmin();

    mockData();

    $farm = FarmModel::first();
    $farm->employees()->save($la);

    expect($farm->employees)->toBeObject();
    expect($farm->employees->toArray())->toHaveCount(1);


    expect($la->farm_id)->toEqual($farm->id);
    expect($la->hasRole("localadmin"))->toBeTrue();
    expect($farm->localadmin->name)->toBe($la->name);
    expect(User::role('localadmin')->first()->farm_id)->toEqual($farm->id);

    livewire(FarmDetails::class, [$farm->id])->call("removeLocalAdmin");

    $la->refresh();
    expect($la->hasRole("localadmin"))->toBeFalse();
});
