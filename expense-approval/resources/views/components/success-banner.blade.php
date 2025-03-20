@if(session('success'))
    <div
        x-data="{ showBanner: true }"
        x-show="showBanner"
        class="success-banner"
    >
        <div class="success-banner-container">
            <div class="flex items-center">
                <p class="ml-3 text-sm text-green-600 font-medium">
                    {{ session('success') }}
                </p>
            </div>
            <button
                @click="showBanner = false"
                class="ml-auto -mx-1.5 -my-1.5 p-1.5 inline-flex text-green-500 hover:text-green-600 rounded-lg focus:ring-2 focus:ring-green-400"
            >
                <span class="sr-only">Dismiss</span>
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
@endif
