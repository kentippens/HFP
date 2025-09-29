<x-filament-panels::page>
    <div class="fi-page-content">
        <div class="grid gap-y-6">
            {{-- Profile Information Section --}}
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <form wire:submit="updateProfile">
                    <div class="fi-section-content-ctn">
                        <div class="fi-section-content p-6">
                            {{ $this->profileForm }}
                        </div>
                    </div>

                    <div class="fi-form-actions px-6 pb-6">
                        <div class="fi-ac gap-3 flex flex-wrap items-center justify-start">
                            <x-filament::button
                                type="submit"
                                size="sm"
                            >
                                Update Profile
                            </x-filament::button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Password Update Section --}}
            <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <form wire:submit="updatePassword">
                    <div class="fi-section-content-ctn">
                        <div class="fi-section-content p-6">
                            {{ $this->passwordForm }}

                            @if(auth()->user()->password_changed_at)
                                <div class="mt-4 rounded-lg bg-gray-50 px-4 py-3 dark:bg-gray-800">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <span class="font-medium">Last changed:</span>
                                        {{ auth()->user()->password_changed_at->diffForHumans() }}
                                        <span class="text-gray-500 dark:text-gray-500">
                                            ({{ auth()->user()->getPasswordAge() }} days ago)
                                        </span>
                                    </p>
                                </div>
                            @endif

                            @if(auth()->user()->needsPasswordChange())
                                <div class="mt-4 rounded-lg bg-warning-50 p-4 dark:bg-warning-500/10">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-warning-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-warning-800 dark:text-warning-400">
                                                Password Update Required
                                            </p>
                                            <p class="mt-1 text-sm text-warning-700 dark:text-warning-300">
                                                Your password has expired and must be changed.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="fi-form-actions px-6 pb-6">
                        <div class="fi-ac gap-3 flex flex-wrap items-center justify-start">
                            <x-filament::button
                                type="submit"
                                size="sm"
                            >
                                Update Password
                            </x-filament::button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Password Requirements Information --}}
            <div class="fi-section rounded-xl bg-gray-50 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/10">
                <div class="p-6">
                    <div class="flex items-center gap-x-3">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            Password Requirements
                        </h3>
                    </div>

                    <div class="mt-4 border-l-4 border-gray-200 pl-4 dark:border-gray-700">
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <li class="flex items-start">
                                <svg class="mr-2 mt-0.5 h-4 w-4 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Minimum {{ config('security.auth.password.min_length', 12) }} characters</span>
                            </li>
                            @if(config('security.auth.password.require_uppercase', true))
                                <li class="flex items-start">
                                    <svg class="mr-2 mt-0.5 h-4 w-4 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                    <span>At least one uppercase letter (A-Z)</span>
                                </li>
                            @endif
                            @if(config('security.auth.password.require_lowercase', true))
                                <li class="flex items-start">
                                    <svg class="mr-2 mt-0.5 h-4 w-4 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                    <span>At least one lowercase letter (a-z)</span>
                                </li>
                            @endif
                            @if(config('security.auth.password.require_numbers', true))
                                <li class="flex items-start">
                                    <svg class="mr-2 mt-0.5 h-4 w-4 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                    <span>At least one number (0-9)</span>
                                </li>
                            @endif
                            @if(config('security.auth.password.require_symbols', true))
                                <li class="flex items-start">
                                    <svg class="mr-2 mt-0.5 h-4 w-4 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                    <span>At least one special character (!@#$%^&*)</span>
                                </li>
                            @endif
                            <li class="flex items-start">
                                <svg class="mr-2 mt-0.5 h-4 w-4 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Cannot reuse last {{ config('security.auth.password.history_count', 5) }} passwords</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="mr-2 mt-0.5 h-4 w-4 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Cannot contain personal information</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="mr-2 mt-0.5 h-4 w-4 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Cannot be a common password</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>