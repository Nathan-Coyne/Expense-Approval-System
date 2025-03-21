<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Approval</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-sm py-4 px-6 mb-0">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-xl font-bold text-gray-800">
                Expense Approval System
            </div>
            <div class="flex items-center gap-4">
                <livewire:logout />
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-0">
        {{ $slot }}
    </div>
    @livewireScripts
    @livewireScriptConfig
</body>
</html>

