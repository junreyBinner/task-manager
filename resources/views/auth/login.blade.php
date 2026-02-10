<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="email" class="block text-sm font-medium text-gray-700">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>Work Email</span>
                    </div>
                </label>
                <span class="text-xs text-gray-500">Required</span>
            </div>
            <input id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="you@company.com"
                class="input-task w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-sm font-medium text-gray-700">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>Password</span>
                    </div>
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs text-indigo-600 hover:text-indigo-800">
                    Forgot password?
                </a>
                @endif
            </div>
            <input id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
                class="input-task w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me"
                    name="remember"
                    type="checkbox"
                    class="checkbox-task rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="remember_me" class="ml-2 text-sm text-gray-600">
                    Keep me signed in
                </label>
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                30 days
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="btn-primary w-full py-3 px-4 rounded-lg text-white font-semibold shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                <span>Access Task Dashboard</span>
            </div>
        </button>

        <!-- Demo Account Note -->
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-blue-50 rounded-lg">
                <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-xs text-blue-700">Demo: demo@taskflow.com / password</span>
            </div>
        </div>
    </form>
</x-guest-layout>