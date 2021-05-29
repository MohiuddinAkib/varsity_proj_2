<?php

namespace App\Http\Livewire;

use App\Contract\IUserRole;
use App\Models\HealthCondition;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class HealthConditionTable extends LivewireDatatable
{
    public $model = HealthCondition::class;

    public function builder()
    {
        $farm_ids = auth()->user()->farms->map->id;

        if (auth()->user()->hasRole(IUserRole::LOCAL_ADMIN)) {
            $farm_ids = [auth()->user()->farm->id];
        }

        return HealthCondition::query()
            ->whereHas("cow", function (Builder $query) use ($farm_ids) {
                $query->whereIn("farm_id", $farm_ids);
            });
    }

    public function columns()
    {
        return [
            Column::name("id")->hide(),
            Column::name("cow.name")->label("Cow serial")->filterable(),
            Column::name("condition")->label("Status"),
            Column::name("note")->label("Note")->truncate(),
            DateColumn::name("created_at")->label("Record date"),
            Column::delete()
        ];
    }
}
