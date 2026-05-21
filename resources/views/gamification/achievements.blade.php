@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="bg-slate-900 border border-slate-800 shadow-sm p-8 text-white flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold tracking-widest uppercase mb-1">Registro de Conquistas</h2>
            <p class="text-slate-400 text-sm font-medium uppercase tracking-wide">Méritos e Certificações Obtidas</p>
        </div>
        <div class="text-4xl text-slate-600">
            <i class="fa-solid fa-certificate"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($allAchievements as $achievement)
            @php $unlocked = in_array($achievement->id, $userAchievements); @endphp
            <div class="bg-white border border-slate-200 shadow-sm p-6 flex flex-col items-center text-center relative transition {{ $unlocked ? 'border-slate-400' : 'opacity-50' }}">
                
                @if($unlocked)
                    <div class="absolute top-3 right-3 text-slate-900 text-lg">
                        <i class="fa-solid fa-check"></i>
                    </div>
                @endif

                <div class="w-16 h-16 flex items-center justify-center text-3xl mb-4 {{ $unlocked ? 'text-slate-900' : 'text-slate-300' }}">
                    <i class="{{ $achievement->icon ?? 'fa-solid fa-star' }}"></i>
                </div>
                
                <h3 class="font-bold text-slate-900 mb-1 tracking-tight">{{ $achievement->name }}</h3>
                <p class="text-xs text-slate-500 mb-6 font-medium">{{ $achievement->description }}</p>
                
                <div class="mt-auto border border-slate-300 bg-slate-50 text-slate-700 font-bold px-3 py-1 text-xs uppercase tracking-widest">
                    +{{ $achievement->xp_reward }} XP
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
