<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Workshop Flutter UI – Roadshow Syneps')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            scroll-behavior: smooth;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #3b82f6, #2dd4bf, #14b8a6);
        }

        .gradient-text {
            background: linear-gradient(135deg, #3b82f6, #2dd4bf, #14b8a6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-icon {
            background: linear-gradient(135deg, #3b82f6, #2dd4bf, #14b8a6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <img src="{{ asset('img/logo.png') }}" alt="logo" class="w-10 h-10 mr-3" />
                    <h1 class="text-xl font-bold gradient-text">Syneps</h1>
                </div>
                <div class="hidden md:block">
                    <div class="flex items-center space-x-8">
                        <a href="#about" class="text-gray-700 hover:text-blue-600 transition-colors">About</a>
                        <a href="#benefits" class="text-gray-700 hover:text-blue-600 transition-colors">Benefits</a>
                        <a href="#details" class="text-gray-700 hover:text-blue-600 transition-colors">Details</a>
                        <x-gradient-button href="/login" type="link">login</x-gradient-button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-lg font-bold gradient-text mb-4">Workshop Flutter UI – Roadshow Syneps</h3>
                    <p class="text-gray-600 mb-4">Master the art of creating beautiful Flutter UIs with our
                        comprehensive workshop.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="gradient-icon text-2xl hover:scale-110 transition-transform">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="gradient-icon text-2xl hover:scale-110 transition-transform">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="gradient-icon text-2xl hover:scale-110 transition-transform">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="gradient-icon text-2xl hover:scale-110 transition-transform">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#about" class="text-gray-600 hover:text-blue-600 transition-colors">About
                                Workshop</a></li>
                        <li><a href="#benefits" class="text-gray-600 hover:text-blue-600 transition-colors">Benefits</a>
                        </li>
                        <li><a href="#details" class="text-gray-600 hover:text-blue-600 transition-colors">Details</a>
                        </li>
                        <li><a href="#register" class="text-gray-600 hover:text-blue-600 transition-colors">Register</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Contact Info</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li><i class="fas fa-envelope gradient-icon mr-2"></i> info@syneps.com</li>
                        <li><i class="fas fa-phone gradient-icon mr-2"></i> +62 123 456 7890</li>
                        <li><i class="fas fa-map-marker-alt gradient-icon mr-2"></i> Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-600">
                <p>&copy; {{ date('Y') }} Syneps. All rights reserved.</p>
            </div>
        </div>
    </footer>


</body>

</html>
