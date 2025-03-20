<div class="page-center">
    <div class="form-container">
        <h2 class="form-title">Login</h2>
        <form wire:submit.prevent="authenticate" class="mt-6 space-y-6">
            <div>
                <label for="email" class="input-label">Email</label>
                <input
                    wire:model="form.email"
                    type="email"
                    id="email"
                    class="w-full input-text @error('form.email') border-red-500 @enderror"
                    placeholder="Enter your email"
                    required
                >
                @error('form.email')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="input-label">Password</label>
                <input
                    wire:model="form.password"
                    type="password"
                    id="password"
                    class="w-full input-text @error('form.email') border-red-500 @enderror"
                    placeholder="Enter your password"
                    required
                >
                @error('form.password')
                    <p class="input-error">{{ $message }}</p>
                @enderror
                @error('login')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="submit-button">Login</button>
            </div>
        </form>
    </div>
</div>
