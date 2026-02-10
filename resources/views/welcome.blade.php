<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="TaskFlow - Simple and powerful task management application">

    <title>TaskFlow - Get Things Done</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="h-10 w-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-md">
                            <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-gray-800">TaskFlow</span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="#features" class="text-gray-600 hover:text-blue-600 font-medium">Features</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-blue-600 font-medium">How It Works</a>
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Login</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                        Get Started
                    </a>
                    @endif
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    Organize Your Work, <br>
                    <span class="text-yellow-300">Boost Your Productivity</span>
                </h1>
                <p class="text-xl md:text-2xl mb-10 opacity-90 max-w-3xl mx-auto">
                    TaskFlow helps you manage tasks, track progress, and achieve your goals faster.
                    Simple, intuitive, and powerful task management for everyone.
                </p>
                <div class="space-x-4">
                    @auth
                    <a href="{{ route('dashboard') }}"
                        class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-full text-lg font-bold inline-flex items-center space-x-2 transition transform hover:scale-105">
                        <span>Go to Dashboard</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                    @else
                    <a href="{{ route('register') }}"
                        class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-full text-lg font-bold inline-flex items-center space-x-2 transition transform hover:scale-105 pulse-animation">
                        <span>Start Free Today</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </a>
                    <a href="#features"
                        class="bg-transparent border-2 border-white hover:bg-white/10 px-8 py-4 rounded-full text-lg font-bold transition">
                        Learn More
                    </a>
                    @endauth
                </div>
            </div>

            <!-- Hero Image/Preview -->
            <div class="mt-20 max-w-5xl mx-auto bg-white/10 backdrop-blur-sm rounded-2xl p-8 shadow-2xl">
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="h-3 w-24 bg-gray-200 rounded"></div>
                            <div class="h-3 w-16 bg-gray-200 rounded"></div>
                            <div class="h-3 w-20 bg-gray-200 rounded"></div>
                        </div>
                        <div class="h-8 w-24 bg-blue-500 rounded"></div>
                    </div>

                    <!-- Task Preview -->
                    <div class="space-y-4">
                        @for($i = 0; $i < 4; $i++)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="h-6 w-6 rounded-full border-2 border-gray-300"></div>
                                <div>
                                    <div class="h-4 w-48 bg-gray-200 rounded mb-2"></div>
                                    <div class="h-3 w-32 bg-gray-100 rounded"></div>
                                </div>
                            </div>
                            <div class="h-8 w-20 bg-green-500 rounded-lg"></div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Powerful Features</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Everything you need to manage your tasks efficiently
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg feature-card">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Smart Task Management</h3>
                    <p class="text-gray-600 mb-6">
                        Create, organize, and prioritize tasks with ease. Set deadlines, add descriptions, and categorize your work.
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Create unlimited tasks
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Set priorities and deadlines
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Add detailed descriptions
                        </li>
                    </ul>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg feature-card">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Progress Tracking</h3>
                    <p class="text-gray-600 mb-6">
                        Visualize your progress with beautiful charts and statistics. Stay motivated by tracking completed tasks.
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Real-time progress dashboard
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Task completion statistics
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Achievement milestones
                        </li>
                    </ul>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg feature-card">
                    <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Secure & Private</h3>
                    <p class="text-gray-600 mb-6">
                        Your data is safe with us. We use industry-standard security practices to protect your information.
                    </p>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Bank-level encryption
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Private cloud storage
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Regular backups
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">How It Works</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Get started in three simple steps
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-blue-600">1</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Sign Up</h3>
                    <p class="text-gray-600">
                        Create your free account in less than a minute. No credit card required.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-green-600">2</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Add Tasks</h3>
                    <p class="text-gray-600">
                        Start adding your tasks. Organize them by priority, deadline, or category.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-purple-600">3</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Track Progress</h3>
                    <p class="text-gray-600">
                        Watch your productivity soar as you complete tasks and achieve your goals.
                    </p>
                </div>
            </div>

            <div class="text-center mt-16">
                @auth
                <a href="{{ route('dashboard') }}"
                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-10 py-4 rounded-full text-lg font-bold inline-flex items-center space-x-2 transition transform hover:scale-105">
                    <span>Go to Your Dashboard</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                @else
                <a href="{{ route('register') }}"
                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-10 py-4 rounded-full text-lg font-bold inline-flex items-center space-x-2 transition transform hover:scale-105">
                    <span>Get Started For Free</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="font-bold text-xl">TaskFlow</span>
                    </a>
                    <p class="mt-4 text-gray-400 max-w-md">
                        The simple and powerful task management solution for individuals and teams.
                    </p>
                </div>

                <div class="flex space-x-8">
                    <div>
                        <h4 class="font-bold text-lg mb-4">Product</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#features" class="hover:text-white transition">Features</a></li>
                            <li><a href="#how-it-works" class="hover:text-white transition">How It Works</a></li>
                            <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-lg mb-4">Company</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition">About Us</a></li>
                            <li><a href="#" class="hover:text-white transition">Contact</a></li>
                            <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-lg mb-4">Connect</h4>
                        <ul class="space-y-2 text-gray-400">
                            @if (Route::has('login'))
                            @auth
                            <li><a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard</a></li>
                            <li><a href="{{ route('profile.edit') }}" class="hover:text-white transition">Profile</a></li>
                            @else
                            <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-white transition">Register</a></li>
                            @endauth
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} TaskFlow. All rights reserved.</p>
                <p class="mt-2">Built with Laravel & Tailwind CSS</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>