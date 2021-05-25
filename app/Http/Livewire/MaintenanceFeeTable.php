<?php

namespace App\Http\Livewire;

use App\Models\MaintenanceFee;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class MaintenanceFeeTable extends LivewireDatatable
{
    public $exportable = true;

    public function builder()
    {
        return MaintenanceFee::query()->whereMonth("date_of_incident", now()->month);
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
