<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaskFlow') }} - Task Manager</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #818cf8;
            --success-color: #10b981;
            --task-bg: #f8fafc;
            --task-border: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        .task-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow:
                0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -1px rgba(0, 0, 0, 0.06),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.1);
        }

        .input-task {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .input-task:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            background: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .checkbox-task:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .progress-bar {
            height: 4px;
            background: linear-gradient(to right, #4f46e5, #818cf8);
            border-radius: 2px;
            transition: width 0.3s ease;
        }
    </style>
</head>

<body class="text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center p-4 sm:p-6">
        <!-- Animated Background Elements -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse delay-1000"></div>
        </div>

        <!-- Header -->
        <div class="w-full max-w-md mb-8 relative">
            <div class="flex items-center justify-center space-x-3">
                <div class="relative">
                    <div class="p-3 bg-white rounded-xl shadow-sm border border-gray-100">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full animate-ping"></div>
                    </div>
                </div>
                <div class="text-left">
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">TaskFlow</h1>
                    <p class="text-sm text-gray-600">Organize. Prioritize. Accomplish.</p>
                </div>
            </div>
        </div>

        <!-- Main Auth Card -->
        <div class="w-full sm:max-w-md relative">
            <div class="task-card rounded-2xl overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex space-x-2">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-800">
                                @if(request()->routeIs('login'))
                                Task Manager Login
                                @elseif(request()->routeIs('register'))
                                Create Task Manager Account
                                @endif
                            </h2>
                        </div>
                        <div class="text-xs px-3 py-1 bg-white rounded-full border border-gray-200 text-gray-600">
                            v2.1
                        </div>
                    </div>

                    <!-- Progress Indicator -->
                    <!-- <div class="mt-3">
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                            <span>Task Manager</span>
                            <span>@if(request()->routeIs('login')) 50% @else 25% @endif</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="progress-bar" style="width: @if(request()->routeIs('login')) 50% @else 25% @endif"></div>
                        </div>
                    </div>
                </div> -->

                <!-- Form Content -->
                <div class="p-6 sm:p-8">
                    {{ $slot }}
                </div>

                <!-- Card Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-1 text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>256-bit SSL</span>
                            </div>
                            <div class="h-4 w-px bg-gray-300"></div>
                            <div class="flex items-center space-x-1 text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span>Fast</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <span class="text-xs text-gray-500">Online</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="mt-4 grid grid-cols-3 gap-3 text-center">
                <div class="bg-white/80 backdrop-blur-sm rounded-lg p-3 border border-gray-200">
                    <div class="text-xs text-gray-500">Active Users</div>
                    <div class="font-bold text-indigo-600">1.2K+</div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg p-3 border border-gray-200">
                    <div class="text-xs text-gray-500">Tasks Managed</div>
                    <div class="font-bold text-indigo-600">45K+</div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm rounded-lg p-3 border border-gray-200">
                    <div class="text-xs text-gray-500">Uptime</div>
                    <div class="font-bold text-green-600">99.9%</div>
                </div>
            </div>
        </div>

        <!-- Links & Footer -->
        <div class="mt-8 text-center space-y-4 relative">
            @if(request()->routeIs('login'))
            <p class="text-sm text-gray-600">
                New to TaskFlow?
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 hover:underline ml-1">
                    Start Managing Tasks →
                </a>
            </p>
            @elseif(request()->routeIs('register'))
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 hover:underline ml-1">
                    Continue Managing Tasks →
                </a>
            </p>
            @endif

            <div class="text-xs text-gray-500 pt-4 border-t border-gray-200">
                © {{ date('Y') }} TaskFlow Manager. Streamline your workflow.
            </div>
        </div>
    </div>
</body>

</html>