<?php

namespace App\Http\Livewire;

use App\Models\User;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class EmployeeListTable extends LivewireDatatable
{
    public function builder()
    {
        $farm_id = auth()->user()->farm->id;

        return User::query()->role("employee")->whereFarmId($farm_id);
    }

    public function columns()
    {
        return [
            Column::name("id")->hide(),
            Column::name("name")
                ->label("Name")
                ->filterable()
                ->searchable(),
            Column::name("contact_number")
                ->label("Contact number")
                ->filterable()
                ->searchable(),
            Column::name("permanent_address")
                ->label("Permanent Address")
                ->filterable()
                ->searchable(),
            Column::name("current_address")
                ->label("Current Address")
                ->filterable()
                ->searchable(),
            Column::name("roles.name")
                ->label("Working position")
                ->filterable(),
            DateColumn::name("join_date")
                ->label("Joining date")
                ->filterable(),
            NumberColumn::name("salary_figure")
                ->label("Salary (TK)")
                ->filterable(),
            Column::delete(),
        ];
    }
}
