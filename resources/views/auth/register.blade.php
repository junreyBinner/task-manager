<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Full Name</span>
                </div>
            </label>
            <input id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="John Doe"
                class="input-task w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Work Email</span>
                </div>
            </label>
            <input id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                placeholder="you@company.com"
                class="input-task w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Password</span>
                </div>
            </label>
            <input id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="Minimum 8 characters"
                class="input-task w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
            <div class="mt-2 grid grid-cols-4 gap-2">
                <div class="h-1 rounded-full bg-gray-200"></div>
                <div class="h-1 rounded-full bg-gray-200"></div>
                <div class="h-1 rounded-full bg-gray-200"></div>
                <div class="h-1 rounded-full bg-gray-200"></div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span>Confirm Password</span>
                </div>
            </label>
            <input id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Re-enter your password"
                class="input-task w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms & Privacy -->
        <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg">
            <input id="terms"
                type="checkbox"
                required
                class="checkbox-task mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            <label for="terms" class="text-sm text-gray-600">
                I agree to the
                <a href="#" class="text-indigo-600 hover:text-indigo-800">Terms of Service</a>
                and
                <a href="#" class="text-indigo-600 hover:text-indigo-800">Privacy Policy</a>.
                TaskFlow will manage my tasks securely.
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="btn-primary w-full py-3 px-4 rounded-lg text-white font-semibold shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span>Create Task Manager Account</span>
            </div>
        </button>

        <!-- Quick Start -->
        <div class="text-center pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600 mb-3">Start managing tasks in seconds</p>
            <div class="flex items-center justify-center space-x-4 text-xs text-gray-500">
                <div class="flex items-center">
                    <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
                    <span>Unlimited tasks</span>
                </div>
                <div class="flex items-center">
                    <div class="w-2 h-2 rounded-full bg-blue-500 mr-2"></div>
                    <span>Team collaboration</span>
                </div>
                <div class="flex items-center">
                    <div class="w-2 h-2 rounded-full bg-purple-500 mr-2"></div>
                    <span>Priority support</span>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>