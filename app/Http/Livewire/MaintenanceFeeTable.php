<?php

namespace App\Http\Livewire;

use App\Contract\IUserRole;
use App\Models\MaintenanceFee;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class MaintenanceFeeTable extends LivewireDatatable
{
    public $exportable = true;

    public function builder()
    {
        $farm_ids = auth()->user()->farms->map->id;

        if (auth()->user()->hasRole(IUserRole::LOCAL_ADMIN)) {
            $farm_ids = [auth()->user()->farm->id];
        }

        return MaintenanceFee::query()->whereMonth("date_of_incident", now()->month)->whereIn("farm_id", $farm_ids);
    }

    public function columns()
    {
        return [
            Column::name("id")->hide(),
            Column::name("farm.name")
                ->label("Farm")
                ->filterable(),
            NumberColumn::name("expense_amount")
                ->label("Expense amount (TK)")
                ->filterable(),
            Column::name("reason")
                ->label("Reason")
                ->truncate(20),
            DateColumn::name("date_of_incident")
                ->label("Date of incident")
                ->filterable(),
            Column::delete()
        ];
    }
}
