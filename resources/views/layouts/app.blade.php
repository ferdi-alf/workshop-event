<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        ::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.25);
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: rgba(0, 0, 0, 0.4);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #075985, #0284c7, #28a088);
        }

        .gradient-text {
            background: linear-gradient(135deg, #075985, #0284c7, #28a088);
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

<body class="font-sans relative antialiased bg-gradient-to-br from-sky-800 via-sky-700 to-teal-400 min-h-screen">
    @stack('modals')

    <div class="h-svh  grid grid-cols-12 gap-3 p-7">

        <div class="col-span-2">
            @include('components.sidebar')
        </div>
        <!-- Page Content -->
        <div
            class="w-full  border-3 border-white/65 col-span-10 bg-white/35 h-full
        overflow-x-auto backdrop-blur-xl rounded-xl p-6 shadow-lg
        scrollbar">
            @yield('content')
        </div>

    </div>

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
