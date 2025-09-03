<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - TPA Al Muhajirin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-neutral-900 dark:to-neutral-800">
    <div class="flex min-h-screen">
        <!-- Left Side - Login Form -->
        <div class="flex flex-1 flex-col justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <div class="bg-white dark:bg-neutral-800 p-4 rounded-full shadow-lg">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>

                <h2 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                    TPA Al Muhajirin
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Sistem Informasi Manajemen TPA
                </p>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white dark:bg-neutral-900 py-8 px-6 shadow-xl rounded-2xl border border-gray-200 dark:border-neutral-700">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        @if($errors->any())
                            <div class="rounded-lg bg-red-50 p-4 border border-red-200 dark:bg-red-900/20 dark:border-red-800">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-800 dark:text-red-400">
                                            {{ $errors->first() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email
                            </label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                       class="block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-600 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                       placeholder="Masukkan email Anda">
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Password
                            </label>
                            <div class="mt-2">
                                <input id="password" name="password" type="password" required
                                       class="block w-full rounded-lg border-gray-300 py-3 px-4 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-600 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                       placeholder="Masukkan password Anda">
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" 
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:focus:ring-blue-500">
                            <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Ingat saya
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" 
                                    class="flex w-full justify-center rounded-lg bg-blue-600 py-3 px-4 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Masuk
                            </button>
                        </div>
                    </form>

                    <!-- Demo Credentials -->
                    <div class="mt-6 p-4 bg-gray-50 dark:bg-neutral-800 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Demo Login:</h4>
                        <div class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                            <p><strong>Admin:</strong> admin@tpa-almuhajirin.id / admin123</p>
                            <p><strong>Ustadz:</strong> ahmad@tpa-almuhajirin.id / ustadz123</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Image/Illustration -->
        <div class="hidden lg:flex lg:flex-1 lg:flex-col lg:justify-center lg:px-8">
            <div class="mx-auto max-w-md text-center">
                <div class="aspect-square bg-gradient-to-br from-blue-400 to-indigo-600 rounded-3xl shadow-2xl mb-8 flex items-center justify-center">
                    <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Selamat Datang
                </h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Sistem informasi manajemen untuk TPA Al Muhajirin. 
                    Kelola data santri, ustadz, dan jadwal pembelajaran dengan mudah.
                </p>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
</body>
</html>