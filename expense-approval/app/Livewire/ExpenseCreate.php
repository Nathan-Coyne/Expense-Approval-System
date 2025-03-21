<?php

namespace App\Livewire;

use App\Enum\PlatformPermissions;
use App\Jobs\ExpenseCreatedNotification;
use App\Livewire\Forms\ExpenseForm;
use App\Models\Category\ExpenseCategory;
use App\Models\Expense;
use App\Models\File;
use App\Models\Platform;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ExpenseCreate extends Component
{
    use WithFileUploads;

    public ExpenseForm $form;
    public $amount;
    public $hasSubmitExpensePermission;

    public function mount()
    {
        $this->hasSubmitExpensePermission =
            Auth::user()->hasPermission(
                PlatformPermissions::SUBMIT_EXPENSES->value
            );

        if (!$this->hasSubmitExpensePermission) {
            return redirect()->route('dashboard');
        }
    }

    public function updateAmount()
    {
        $this->form->amount = (int) round((float) $this->amount * 100);
    }

    public function save() {
        if (!$this->hasSubmitExpensePermission) {
            return redirect()->route('dashboard');
        }

        $this->form->validate();
        $image = $this->form->image->store('receipts', 'public');

        $expense = null;
        $status = null;
        try {
            DB::transaction(function () use ($image, &$expense, &$status) {
                $file = File::create([
                    'name' => $this->form->image->getClientOriginalName(),
                    'path' => $image,
                    'size' => $this->form->image->getSize(),
                    'extension' => $this->form->image->getClientOriginalExtension(),
                    'type' => $this->form->image->getMimeType()
                ]);
                $expense = Expense::create([
                    'description' => $this->form->description,
                    'amount' => $this->form->amount,
                    'category_id' => ExpenseCategory::where('slug', Str::slug($this->form->category))->first()->id,
                    'file_id' => $file->id,
                    'user_id' => auth()->id()
                ]);

                $expense->statuses()->attach($status = Status::where('slug', 'pending')->first());
            });
        } catch (\Exception $e) {
            $this->form->image->delete('receipts', 'public');
            return $this->addError('create', 'Error creating expense try again later or contact support');
        }

        ExpenseCreatedNotification::dispatch($expense, $status);

        return redirect()->to('/dashboard')->with('success', 'Expense created!');
    }

    public function render()
    {
        return view('livewire.expense-create')->layout('layouts.app');
    }
}
