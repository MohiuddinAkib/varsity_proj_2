<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Cow;
use App\Contract\IUserRole;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class CowRecordTable extends LivewireDatatable
{
    public $exportable = true;

    public function builder()
    {
        $farm_ids = auth()->user()->farms->map->id;

        if (auth()->user()->hasRole(IUserRole::LOCAL_ADMIN)) {
            $farm_ids = [auth()->user()->farm->id];
        }

        return Cow::query()->whereIn("farm_id", $farm_ids);
    }

    public function columns()
    {
        return [
            Column::name("id")->hide(),
            Column::name("name")
                ->label("Cow serial")
                ->filterable()
                ->searchable(),
            Column::name("farm.name")
                ->label("Farm")
                ->filterable()
                ->searchable(),
            Column::name("breed.name")
                ->label("Breed")
                ->filterable()
                ->searchable(),
            NumberColumn::name("weight")
                ->label("Weight (kg)")
                ->filterable(),
            Column::name("type")
                ->label("Cow type")
                ->filterable(),
            Column::name("gender")
                ->label("Gender")
                ->filterable(),
            BooleanColumn::name("is_marked_for_sale")
                ->label("Marked for sale"),
            BooleanColumn::name("is_sold")
                ->label("Sold"),
            DateColumn::callback(["dob"], function ($dob) {
                $dob = Carbon::parse($dob);
                $age = $dob->diff(now())->format("%y years, %m months and %d days");
                return $age;
            })
                ->label("Age"),
            Column::name("description")
                ->label("Description")
                ->truncate(30),
            Column::callback(['id', 'name', "is_sold", "is_marked_for_sale"], function ($id, $name, $is_sold, $is_marked_for_sale) {
                return view('cow-record-table-actions', compact('id', 'name', "is_sold", "is_marked_for_sale"));
            })
        ];
    }

    public function markForSale(int $id)
    {
        $cow = Cow::findOrFail($id);

        $cow->is_marked_for_sale = !$cow->is_marked_for_sale;

        $cow->save();
    }

    public function markSold(int $id)
    {
        $cow = Cow::findOrFail($id);

        $cow->is_sold = !$cow->is_sold;

        $cow->save();
    }
}
