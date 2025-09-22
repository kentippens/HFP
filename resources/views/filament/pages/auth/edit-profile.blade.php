<x-filament-panels::page>
    <div class="space-y-8">
        <form wire:submit="updateProfile">
            {{ $this->profileForm }}

            <div class="mt-6">
                <x-filament::button type="submit">
                    Update Profile
                </x-filament::button>
            </div>
        </form>

        <hr class="border-gray-200 dark:border-gray-700" />

        <form wire:submit="updatePassword">
            {{ $this->passwordForm }}

            @if(auth()->user()->password_changed_at)
                <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                    Password last changed: {{ auth()->user()->password_changed_at->diffForHumans() }}
                    ({{ auth()->user()->getPasswordAge() }} days ago)
                </div>
            @endif

            @if(auth()->user()->needsPasswordChange())
                <div class="mt-4 p-4 bg-warning-50 dark:bg-warning-900/50 rounded-lg">
                    <p class="text-sm text-warning-700 dark:text-warning-300">
                        Your password has expired and must be changed.
                    </p>
                </div>
            @endif

            <div class="mt-6">
                <x-filament::button type="submit">
                    Update Password
                </x-filament::button>
            </div>
        </form>

        <div class="mt-8 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Password Requirements:</h3>
            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                <li>• Minimum {{ config('security.auth.password.min_length', 12) }} characters</li>
                @if(config('security.auth.password.require_uppercase', true))
                    <li>• At least one uppercase letter</li>
                @endif
                @if(config('security.auth.password.require_lowercase', true))
                    <li>• At least one lowercase letter</li>
                @endif
                @if(config('security.auth.password.require_numbers', true))
                    <li>• At least one number</li>
                @endif
                @if(config('security.auth.password.require_symbols', true))
                    <li>• At least one special character</li>
                @endif
                <li>• Cannot reuse last {{ config('security.auth.password.history_count', 5) }} passwords</li>
                <li>• Cannot contain personal information</li>
                <li>• Cannot be a common password</li>
            </ul>
        </div>
    </div>
</x-filament-panels::page>