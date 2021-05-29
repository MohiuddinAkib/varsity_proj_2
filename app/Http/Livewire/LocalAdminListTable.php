<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Contract\IUserRole;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class LocalAdminListTable extends LivewireDatatable
{
    public $model = User::class;

    public function builder()
    {
        $farm_ids = auth()->user()->farms->map->id;
        return User::query()->role(IUserRole::LOCAL_ADMIN)->whereIn("farm_id", $farm_ids);
    }

    public function columns()
    {
        return [
            Column::name("id")->hide(),
            Column::name("name")->label("Name"),
            Column::name("farm.name")->label("Farm name"),
            DateColumn::name("join_date")->label("Join Date"),
            Column::delete(),
        ];
    }
}
