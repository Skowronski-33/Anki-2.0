<section>
    <header>
        <h2 class="text-lg font-black text-white uppercase tracking-widest">Informações Pessoais</h2>
        <p class="mt-1 text-sm font-medium text-slate-400">Atualize os dados de perfil da sua conta operacional.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nome Completo</label>
            <input id="name" name="name" type="text" class="block w-full bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition px-4 py-3" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <p class="text-sm text-red-500 mt-2 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">E-mail de Acesso</label>
            <input id="email" name="email" type="email" class="block w-full bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition px-4 py-3" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <p class="text-sm text-red-500 mt-2 font-semibold">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-slate-400">
                        Seu endereço de email não está verificado.
                        <button form="send-verification" class="text-sm text-blue-500 hover:text-blue-400 underline transition">
                            Clique aqui para reenviar
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-emerald-500">
                            Um novo link foi enviado.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-white hover:bg-slate-200 text-slate-900 font-bold py-3 px-6 text-sm uppercase tracking-widest transition rounded">
                Salvar Dados
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm font-bold text-emerald-500 uppercase tracking-widest">Atualizado.</p>
            @endif
        </div>
    </form>
</section>
