<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>FlashQuest - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-950 text-slate-300 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-slate-900 border border-slate-800 shadow-sm rounded p-8">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-black text-white tracking-tight uppercase">Login</h1>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-6">
                <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">E-mail</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                        class="block w-full pl-11 pr-4 py-3 bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition" placeholder="operador@sistema.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Senha</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password" 
                        class="block w-full pl-11 pr-12 py-3 bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition" placeholder="••••••••" />
                    
                    <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-white focus:outline-none toggle-password" data-target="password">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mb-8">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-800 bg-slate-950 text-slate-500 shadow-sm focus:ring-0 focus:ring-offset-0">
                    <span class="ms-2 text-xs font-bold text-slate-500 uppercase tracking-widest">Lembrar-me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-slate-400 hover:text-white uppercase tracking-widest transition" href="{{ route('password.request') }}">
                        Recuperar Acesso
                    </a>
                @endif
            </div>

            <div class="flex flex-col space-y-4">
                <button type="submit" class="w-full bg-white hover:bg-slate-200 text-slate-900 font-bold py-3 px-4 rounded text-sm uppercase tracking-widest transition">
                    Autenticar
                </button>
                
                <a class="text-xs text-center font-bold text-slate-500 hover:text-white uppercase tracking-widest transition mt-4" href="{{ route('register') }}">
                    Solicitar Matrícula
                </a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-password');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
        });
    </script>
</body>
</html>
