<section>
    <header>
        <h2 class="text-lg font-black text-white uppercase tracking-widest">Alterar Senha</h2>
        <p class="mt-1 text-sm font-medium text-slate-400">Garanta que sua conta está usando uma senha longa e segura.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Senha Atual</label>
            <input id="update_password_current_password" name="current_password" type="password" class="block w-full bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition px-4 py-3" autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <p class="text-sm text-red-500 mt-2 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nova Senha</label>
            <input id="update_password_password" name="password" type="password" class="block w-full bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition px-4 py-3" autocomplete="new-password" />
            @error('password', 'updatePassword')
                <p class="text-sm text-red-500 mt-2 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Confirmar Nova Senha</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full bg-slate-950 text-white border border-slate-800 rounded focus:ring-0 focus:border-slate-500 transition px-4 py-3" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <p class="text-sm text-red-500 mt-2 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-white hover:bg-slate-200 text-slate-900 font-bold py-3 px-6 text-sm uppercase tracking-widest transition rounded">
                Salvar Senha
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm font-bold text-emerald-500 uppercase tracking-widest">Atualizada.</p>
            @endif
        </div>
    </form>
</section>
