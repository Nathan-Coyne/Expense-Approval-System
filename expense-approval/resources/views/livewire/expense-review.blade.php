<div class="mt-8 overflow-x-auto rounded-lg shadow">
    <x-success-banner></x-success-banner>

    @error('approve')
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
        {{ $message }}
    </div>
    @enderror

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @forelse($expenses as $expense)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $expense->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap max-w-xs">
                    <div class="text-sm text-gray-900">{{ $expense->description }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${{ number_format($expense->amount / 100, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{ $expense->expenseCategory->name ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="mailto:{{ $expense->user->email }}" class="text-blue-600 hover:text-blue-900">
                        {{ $expense->user->email }}
                    </a>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="{{ asset('storage/'.$expense->file->path)}}" target="_blank" class="inline-block">

                        <img src="{{ asset('storage/'.$expense->file->path) }}"
                             alt="Receipt"
                             class="h-16 w-auto max-w-xs object-contain border rounded">
                    </a>
                </td>
                <td class="px-6 py-4 whitespace-nowrap space-x-2">
                    <button
                        wire:click.prevent="approveExpense('{{ $expense->id }}')"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors"
                    >
                        Approve
                    </button>
                    <button
                        wire:click.prevent="rejectExpense('{{ $expense->id }}')"
                        class="px-4 py-2 !bg-red-500 text-white rounded-md hover:!bg-red-700 transition-colors"
                    >
                        Reject
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                    No pending expenses to review
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
