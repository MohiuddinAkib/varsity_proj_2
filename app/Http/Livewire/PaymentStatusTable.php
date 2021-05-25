<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Farm;
use App\Models\Payment;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class PaymentStatusTable extends LivewireDatatable
{
    public $exportable = true;

    public $afterTableSlot = 'components.selected';

    public function builder()
    {
        return Payment::query()->whereMonth("payment_date", now()->month);
    }

    public function columns()
    {
        return [
            Column::name("id")->hide(),
            Column::name("worker.name")
                ->label("Worker name")->filterable(),
            Column::name("worker.farm.name")
                ->label("Worker farm")
            ->filterable($this->farms),
            Column::name("payment_status")
                ->label("Status")
                ->filterable(["paid", "unpaid"]),
            DateColumn::name("payment_date")
                ->label("Paid date"),
            TimeColumn::callback(["payment_date"], function ($payment_date) {
                if (!empty($payment_date)) {
                    return Carbon::parse($payment_date)->format("H:i");
                }
            })
                ->label("Paid time"),
            NumberColumn::name("payment_cut")
                ->label("Payment cut (TK)"),
            NumberColumn::name("payment_bonus")
                ->label("Payment bonus (TK)"),
            Column::name("payment_cut_reason")
                ->label("Payment cut reason")
                ->truncate(),
            Column::name("payment_bonus_reason")
                ->label("Payment bonus reason")
                ->truncate(),
        ];
    }

    public function getFarmsProperty()
    {
        return Farm::pluck("name");
    }
}
