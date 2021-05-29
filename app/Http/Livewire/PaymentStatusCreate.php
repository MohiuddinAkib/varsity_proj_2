<?php

namespace App\Http\Livewire;

use Form;
use App\Models\User;
use Livewire\Component;
use App\Models\Payment;
use App\Contract\IUserRole;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentStatusCreate extends Component
{
    use AuthorizesRequests;

    public string $form_method = "savePayment";
    public string $card_title = "create payment";

    public string $worker_id = "";
    public array $workers = [];
    public string $payment_date = "";
    public string $payment_status = "";
    public string $payment_cut = "0";
    public string $payment_bonus = "0";
    public string $payment_cut_reason = "";
    public string $payment_bonus_reason = "";

    protected function getRules()
    {
        return [
            "payment_cut" => ["integer", "nullable", "min:0"],
            "payment_bonus" => ["integer", "nullable", "min:0"],
            "worker_id" => ["required", "exists:App\Models\User,id"],
            "payment_date" => ["date", "required", "before:" . now()],
            "payment_status" => ["string", "required", Rule::in(["paid", "unpaid"])],
            "payment_cut_reason" => [Rule::requiredIf(fn() => (int)$this->payment_cut > 0), "string"],
            "payment_bonus_reason" => [Rule::requiredIf(fn() => (int)$this->payment_bonus > 0), "string"],
        ];
    }

    public function mount()
    {
        $farm_id = auth()->user()->farm->id;
        $workers = User::role(IUserRole::EMPLOYEE)->whereFarmId($farm_id)->latest()->get();
        $workers = $workers->mapWithKeys(fn($item) => [$item["id"] => $item["name"]])->toArray();

        $this->fill([
            "workers" => $workers,
            "payment_status" => "paid",
            "worker_id" => array_key_first($workers),
        ]);
    }

    public function savePayment()
    {
//        $this->authorize()
        $validated = $this->validate();

        try {
            Payment::create($validated);
            session()->flash("success", "Successfully created payment");

            $this->reset(
                "payment_cut",
                "payment_bonus",
                "worker_id",
                "payment_date",
                "payment_status",
                "payment_cut_reason",
                "payment_bonus_reason",
            );
        } catch (\Exception $e) {
            session()->flash("error", "Something went wrong");
        }
    }

    public function render()
    {
        $inputs = [
            "fields" => [
                "worker_id" => [
                    "label" => Form::label("Worker"),
                    "input" => Form::select("worker_id", $this->workers, null, ["wire:model" => "worker_id"])
                ],
                "payment_status" => [
                    "label" => Form::label("Payment Status"),
                    "input" => Form::select("payment_status", ["paid" => "Paid", "unpaid" => "Unpaid"], null, ["wire:model" => "payment_status"])
                ],
                "payment_date" => [
                    "label" => Form::label("Payment date"),
                    "input" => Form::date("payment_date", null, ["wire:model" => "payment_date"])
                ],
                "payment_cut" => [
                    "label" => Form::label("Payment cut amount"),
                    "input" => Form::number("payment_cut", null, ["wire:model" => "payment_cut", "min" => 0])
                ],
                "payment_bonus" => [
                    "label" => Form::label("Payment bonus amount"),
                    "input" => Form::number("payment_bonus", null, ["wire:model" => "payment_bonus", "min" => 0])
                ],
                "payment_cut_reason" => [
                    "label" => Form::label("Payment cut reason"),
                    "input" => Form::text("payment_cut_reason", null, ["wire:model" => "payment_cut_reason"])
                ],
                "payment_bonus_reason" => [
                    "label" => Form::label("Payment bonus reason"),
                    "input" => Form::text("payment_bonus_reason", null, ["wire:model" => "payment_bonus_reason"])
                ],
            ],
            "form_bottom_buttons" => [
                "submit" => Form::submit("Create"),
            ]
        ];

        return view('livewire.payment-status-create', [
            "inputs" => $inputs
        ]);
    }
}
