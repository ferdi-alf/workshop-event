<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Workshop Flutter UI – Roadshow Syneps')</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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



    <nav class="bg-white shadow-md top-0 z-50 sticky border-gray-200 ">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('img/logo.png') }}" alt="logo" class="w-10 h-10 mr-3" />
                <h1 class="text-xl font-bold gradient-text">Syneps Academy</h1>
            </a>
            <button data-collapse-toggle="navbar-dropdown" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 "
                aria-controls="navbar-dropdown" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
                <ul
                    class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:space-y-0 space-y-3 md:flex-row md:mt-0 md:border-0 md:bg-white ">
                    <li>
                        <a href="#about" class="text-gray-700 hover:text-blue-600 transition-colors">About</a>
                    </li>

                    <li>
                        <a href="#benefits" class="text-gray-700 hover:text-blue-600 transition-colors">Benefits</a>
                    </li>
                    <li>
                        <a href="#details" class="text-gray-700 hover:text-blue-600 transition-colors">Details</a>
                    </li>
                    <li>
                        <x-gradient-button href="/login" type="link">
                            {{ Auth::check() ? 'Dashboard' : 'Login' }}
                        </x-gradient-button>
                    </li>
                </ul>
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
                        <li><i class="fas fa-envelope gradient-icon mr-2"></i> cs@sydemy.com</li>
                        <li><i class="fas fa-phone gradient-icon mr-2"></i> +62-896-3379-8626</li>
                        <li><i class="fas fa-map-marker-alt gradient-icon mr-2"></i>
                            Komplek Rajawali Village, Jl. Rajawali No.1228, 9 Ilir, Ilir Timur II, Palembang City, South
                            Sumatra 30114</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-600">
                <p>&copy; {{ date('Y') }} Syneps Academy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('alert'))
            @php $alert = session('alert'); @endphp

            Swal.fire({
                icon: '{{ $alert['type'] }}',
                title: '{{ $alert['title'] }}',
                text: '{{ $alert['message'] }}',
                confirmButtonColor: '#60a5fa',
                timer: 6000,
                timerProgressBar: true
            });
        @endif

        @if ($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += '• {{ $error }}\n';
            @endforeach

            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: errorMessages,
                confirmButtonColor: '#991b1b'
            });
        @endif
    </script>
</body>

</html>
