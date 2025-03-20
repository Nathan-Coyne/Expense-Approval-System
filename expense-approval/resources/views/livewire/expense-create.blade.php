<div class="page-center">
    <div class="form-container">
        <h2 class="form-title">Create New Expense</h2>

        <form wire:submit.prevent="save" class="mt-6 space-y-6">
            <!-- Description -->
            <div>
                <label for="description" class="input-label">
                    Description
                </label>
                <input
                    type="text"
                    id="description"
                    wire:model="form.description"
                    class="w-full input-text @error('form.description') border-red-500 @enderror"
                    placeholder="Enter expense description"
                >
                @error('form.description')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount -->
            <div>
                <label for="amount" class="input-label">
                    Amount
                </label>
                <div class="relative rounded-md shadow-sm">
                    <input
                        type="number"
                        step="0.01"
                        id="amount"
                        wire:model.live.debounce.500ms="amount"
                        wire:change="updateAmount"
                        wire:model="amount"
                        class="w-full input-text-has-icon @error('form.amount') border-red-500 @enderror"
                        placeholder="0.00"
                    >
                    <div class="input-text-icon">
                        <span class="text-gray-500">£</span>
                    </div>
                </div>
                @error('form.amount')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="input-label">
                    Category
                </label>
                <select
                    id="category"
                    wire:model="form.category"
                    class="w-full bg-white input-text @error('form.category') border-red-500 @enderror"
                >
                    <option value="" selected>Select a category</option>
                    @foreach(App\Enum\ExpenseCategories::cases() as $category)
                        <option value="{{ $category->value }}">{{ $category->value }}</option>
                    @endforeach
                </select>
                @error('form.category')
                <p class="input-error">
                    {{ $message }}. Valid options:
                    @foreach(App\Enum\ExpenseCategories::cases() as $category)
                        {{ $category->value }}@if(!$loop->last),@endif
                    @endforeach
                </p>
                @enderror
            </div>

            <!-- Receipt Image Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Receipt Image
                </label>
                <div class="mt-1 flex items-center space-x-4">
                    <input
                        type="file"
                        wire:model="form.image"
                        accept="image/*"
                        class="w-full"
                    >
                    @if ($form->image)
                        <div class="shrink-0">
                            <img
                                class="h-16 w-16 rounded-md object-cover"
                                src="{{ $form->image->temporaryUrl() }}"
                                alt="Receipt preview"
                            >
                        </div>
                    @endif
                </div>
                @error('form.image')
                <p class="input-error">{{ $message }}</p>
                @enderror
                @error('create')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-6">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="w-full flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                >
                    <span wire:loading.remove>Create Expense</span>
                    <span wire:loading>
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
