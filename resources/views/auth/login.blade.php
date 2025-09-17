<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br  py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header Section -->
            <div class="">
                <a href="/" class="font-bold text-xl flex items-center gap-3">
                    <img src="{{ asset('img/logo.png') }}" alt="logo" class="w-20 h-20 fill-current text-gray-500" />
                    <h1
                        class="bg-transparent text-3xl font-extrabold  text-transparent bg-clip-text bg-gradient-to-br from-blue-500 via-teal-400 to-teal-500">
                        Workshop Flutter UI</h1>
                </a>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 space-y-6 border border-gray-100">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <x-text-input id="email" type="email" name="email" :value="old('email')" required
                                autofocus autocomplete="username" placeholder="Enter your email" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>


                    <div class="space-y-2">
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                        <x-text-input id="password" name="password" type="password" required
                            placeholder="Enter your password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>


                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox"
                                class="w-4 h-4 rounded border-2 border-gray-300 text-blue-600 shadow-sm focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 transition-all duration-200"
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors">
                                {{ __('Remember me') }}
                            </span>
                        </label>


                    </div>

                    <!-- Login Button -->
                    <div class="space-y-4">
                        <button type="submit"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg text-white font-semibold gradient-bg hover:shadow-lg transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            {{ __('Sign In') }}
                        </button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="text-center text-sm text-gray-500">
                    <p>© {{ date('Y') }} Workshop Flutter UI - Roadshow Syneps</p>
                </div>
            </div>
        </div>

        <!-- Custom Styles -->
        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #3b82f6, #2dd4bf, #14b8a6);
            }

            .gradient-text {
                background: linear-gradient(135deg, #3b82f6, #2dd4bf, #14b8a6);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            /* Custom input focus styles */
            .focus\:ring-blue-500:focus {
                --tw-ring-color: rgb(59 130 246 / 0.5);
            }

            /* Smooth animations */
            input:focus {
                transform: translateY(-1px);
            }

            /* Custom checkbox styles */
            input[type="checkbox"]:checked {
                background: linear-gradient(135deg, #3b82f6, #2dd4bf, #14b8a6);
                border-color: transparent;
            }
        </style>



</x-guest-layout>
