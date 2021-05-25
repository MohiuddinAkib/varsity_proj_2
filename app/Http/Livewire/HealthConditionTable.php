<?php

namespace App\Http\Livewire;

use App\Models\HealthCondition;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class HealthConditionTable extends LivewireDatatable
{
    public function builder()
    {
        return HealthCondition::query();
    }

    public function columns()
    {
        return [
            Column::name("id")->hide(),
            Column::name("cow.name")->label("Cow serial")->filterable(),
            Column::name("condition")->label("Status"),
            Column::name("note")->label("Note")->truncate(),
            DateColumn::name("created_at")->label("Record date"),
        ];
    }
}
