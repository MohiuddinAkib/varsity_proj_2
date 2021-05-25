<?php

namespace App\Http\Livewire;

use App\Models\User;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class HostAdminTable extends LivewireDatatable
{
    public $model = User::class;

    public function builder()
    {
        return User::query()->role("hostadmin");
    }


    public function columns()
    {
        return [
//            Column::checkbox(),
            Column::name("id")
                ->hide(),
            Column::name("name")
                ->label("Name")
                ->filterable()
                ->searchable(),
            Column::name("email")
                ->label("Email")
                ->filterable()
                ->searchable(),
            Column::name("contact_number")
                ->label("Contact number")
                ->filterable()
                ->searchable(),
            NumberColumn::name("farms.id:count")
                ->filterable()
                ->label("Farms Count"),
            Column::delete(),
        ];
    }
}
