<?php

namespace App\Http\Livewire;

use App\Models\Cow;
use Carbon\Carbon;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class CowRecordTable extends LivewireDatatable
{
    public $exportable = true;

    public function builder()
    {
        return Cow::query();
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
            DateColumn::callback(["dob"], function ($dob) {
                $dob = Carbon::parse($dob);
                $age = $dob->diff(now())->format("%y years, %m months and %d days");
                return $age;
            })
                ->label("Age"),
            Column::name("description")
                ->label("Description")
                ->truncate(30),
            Column::delete()
        ];
    }
}
