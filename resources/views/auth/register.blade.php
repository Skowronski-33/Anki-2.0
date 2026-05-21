<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>FlashQuest - Registro</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-950 text-slate-300 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-slate-900 border border-slate-800 shadow-sm rounded p-8 my-8">
        
        <div class="text-center mb-8">
            <div class="text-4xl text-slate-600 mb-4">
                <i class="fa-solid fa-id-card"></i>
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight uppercase">Matrícula Operacional</h1>
            <p class="text-slate-500 text-sm font-bold uppercase tracking-widest mt-2">Cadastre-se no sistema</p>
        </div>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nome Completo</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                        class="block w-full pl-11 pr-4 py-3 bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition" placeholder="Nome do Operador" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Email Address -->
            <div class="mb-6">
                <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">E-mail</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
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
                    <input id="password" type="password" name="password" required autocomplete="new-password" 
                        class="block w-full pl-11 pr-12 py-3 bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition" placeholder="••••••••" />
                    <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-white focus:outline-none toggle-password" data-target="password">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-8">
                <label for="password_confirmation" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Confirmar Senha</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-600">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                        class="block w-full pl-11 pr-12 py-3 bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition" placeholder="••••••••" />
                    <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-white focus:outline-none toggle-password" data-target="password_confirmation">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
            </div>

            <div class="flex flex-col space-y-4">
                <button type="submit" class="w-full bg-white hover:bg-slate-200 text-slate-900 font-bold py-3 px-4 rounded text-sm uppercase tracking-widest transition">
                    Efetivar Matrícula
                </button>
                
                <a class="text-xs text-center font-bold text-slate-500 hover:text-white uppercase tracking-widest transition mt-4" href="{{ route('login') }}">
                    Já possui acesso? Autentique-se
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
