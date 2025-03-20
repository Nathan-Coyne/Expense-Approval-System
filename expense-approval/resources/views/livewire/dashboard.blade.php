<div class="min-h-screen p-8">

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard</h1>
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            Welcome back, <span class="text-blue-600">{{$name}}({{ $email }})</span>!
        </h1>
        <x-success-banner />
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($hasSubmitExpensePermission)
            <button
                wire:click="navigateToSubmitExpense"
                class="bg-blue-500 hover:bg-blue-600 text-white p-8 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105"
            >
                <div class="text-center">
                    <div class="text-4xl mb-2">📁</div>
                    <h2 class="text-xl font-semibold">Submit Expense</h2>
                    <p class="text-sm opacity-75 mt-2">Have a company expense submit the here</p>
                </div>
            </button>
            @endif
            @if($hasApproveExpensePermission)
            <button
                wire:click="navigateToReviewExpense"
                class="bg-green-500 hover:bg-green-600 text-white p-8 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105"
            >
                <div class="text-center">
                    <div class="text-4xl mb-2">📊</div>
                    <h2 class="text-xl font-semibold">Review Expense</h2>
                    <p class="text-sm opacity-75 mt-2">This will show you any expenses that are ready for your approval.</p>
                </div>
            </button>
            @endif
            <button
                wire:click="navigateToFeatureThree"
                class="bg-purple-500 hover:bg-purple-600 text-white p-8 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105"
            >
                <div class="text-center">
                    <div class="text-4xl mb-2">🔒</div>
                    <h2 class="text-xl font-semibold">Feature Three</h2>
                    <p class="text-sm opacity-75 mt-2">Description of feature one</p>
                </div>
            </button>

            <button
                wire:click="navigateToFeatureFour"
                class="bg-orange-500 hover:bg-orange-600 text-white p-8 rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105"
            >
                <div class="text-center">
                    <div class="text-4xl mb-2">⚙️</div>
                    <h2 class="text-xl font-semibold">Feature Four</h2>
                    <p class="text-sm opacity-75 mt-2">Description of feature two</p>
                </div>
            </button>
        </div>
    </div>
</div>
