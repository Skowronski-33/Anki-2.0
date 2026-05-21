<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - FlashQuest</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white border border-slate-200 shadow-sm rounded-lg overflow-hidden">
        
        <div class="bg-slate-900 px-6 py-6 text-center border-b border-slate-800">
            <h1 class="text-2xl font-bold text-white tracking-tight">Criar Conta</h1>
        </div>

        <div class="p-6 sm:p-8">
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Name -->
                <div class="mb-5">
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nome</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                        class="block w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-colors" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Email Address -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">E-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                        class="block w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-colors" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    <p id="email-error" class="text-red-600 text-sm mt-1 hidden font-medium">O e-mail deve conter "@" e terminar em ".com" ou similar.</p>
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Senha</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="new-password" 
                            class="block w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-colors pr-10" />
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-900 focus:outline-none toggle-password" data-target="password">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">Confirmar Senha</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                            class="block w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-colors pr-10" />
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-900 focus:outline-none toggle-password" data-target="password_confirmation">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <div class="flex flex-col space-y-4">
                    <button type="submit" id="submitBtn" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-4 rounded transition-colors tracking-wide">
                        Cadastrar
                    </button>
                    
                    <a class="text-sm text-center font-medium text-slate-600 hover:text-slate-900 transition-colors" href="{{ route('login') }}">
                        Já tem conta? Entrar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password Toggle
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

            // Email Validation
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('email-error');
            const form = document.getElementById('registerForm');

            function validateEmail() {
                const value = emailInput.value;
                if (value.length > 0) {
                    // Requires @ and .com
                    if (!value.includes('@') || !value.includes('.com')) {
                        emailError.classList.remove('hidden');
                        emailInput.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                        emailInput.classList.remove('focus:ring-slate-900', 'focus:border-slate-900');
                        return false;
                    } else {
                        emailError.classList.add('hidden');
                        emailInput.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                        emailInput.classList.add('focus:ring-slate-900', 'focus:border-slate-900');
                        return true;
                    }
                }
                emailError.classList.add('hidden');
                return true;
            }

            emailInput.addEventListener('input', validateEmail);
            emailInput.addEventListener('blur', validateEmail);

            form.addEventListener('submit', function(e) {
                if (!validateEmail()) {
                    e.preventDefault();
                    emailInput.focus();
                }
            });
        });
    </script>
</body>
</html>
