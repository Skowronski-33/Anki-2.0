<section class="space-y-6">
    <header>
        <h2 class="text-lg font-black text-red-500 uppercase tracking-widest">Excluir Conta Operacional</h2>
        <p class="mt-1 text-sm font-medium text-slate-400">Uma vez que sua conta for excluída, todos os seus recursos e dados (Decks, XP, Estatísticas) serão apagados permanentemente. Esta ação não pode ser desfeita.</p>
    </header>

    <form method="post" action="{{ route('profile.destroy') }}" class="mt-6 space-y-6" onsubmit="return confirm('ATENÇÃO: Você tem certeza ABSOLUTA que deseja excluir sua conta? Tudo será perdido.');">
        @csrf
        @method('delete')

        <div class="bg-red-950/30 border border-red-900/50 p-4 rounded">
            <label for="password_delete" class="block text-xs font-bold text-red-400 uppercase tracking-widest mb-2">Digite sua senha para confirmar a exclusão</label>
            <input id="password_delete" name="password" type="password" class="block w-full bg-slate-950 text-white border border-red-900/50 rounded focus:ring-0 focus:border-red-500 transition px-4 py-3 placeholder-red-900/30" placeholder="Sua senha" required />
            @error('password', 'userDeletion')
                <p class="text-sm text-red-500 mt-2 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-red-600 hover:bg-red-500 text-white font-bold py-3 px-6 text-sm uppercase tracking-widest transition rounded flex items-center">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i> Excluir Definitivamente
            </button>
        </div>
    </form>
</section>
