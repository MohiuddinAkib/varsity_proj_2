<?php

namespace App\Http\Livewire;

use App\Models\Farm;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class FarmListTable extends LivewireDatatable
{
    public $exportable = true;
    public $model = Farm::class;

    public function builder()
    {
        if (auth()->user()->hasRole("superadmin")) {
            return Farm::query();
        }

        return Farm::query()->whereOwnerId(auth()->id());
    }

    public function columns()
    {
        return [
            Column::name("id")->hide(),
            Column::name("name")
                ->label("Name")
                ->filterable(),
            Column::name("location")
                ->label("Location")
                ->filterable()
                ->searchable(),
            Column::name("owner.name")
                ->label("Owner")
                ->filterable(),
            Column::name("localadmin.name")
                ->label("Local admin")
                ->filterable(),
            DateColumn::name("establish_date")
                ->label("Establish date"),
            Column::delete()
        ];
    }
}
