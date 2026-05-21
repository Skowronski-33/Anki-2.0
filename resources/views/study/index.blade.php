@extends('layouts.app')

@push('scripts')
<style>
    .perspective-1000 { perspective: 1000px; }
    .transform-style-3d { transform-style: preserve-3d; }
    .backface-hidden { backface-visibility: hidden; }
    .rotate-y-180 { transform: rotateY(180deg); }
    .flip-card-inner {
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        transform-style: preserve-3d;
    }
    .flip-card.flipped .flip-card-inner {
        transform: rotateY(180deg);
    }
    .flip-card-front, .flip-card-back {
        backface-visibility: hidden;
    }
    .flip-card-back {
        transform: rotateY(180deg);
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto h-full flex flex-col items-center justify-center py-10" id="study-container">
    
    <div class="w-full flex justify-between items-center mb-6 px-4">
        <a href="{{ route('decks.index') }}" class="text-slate-500 hover:text-white font-semibold uppercase text-sm tracking-wide transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Abortar Missão
        </a>
        <div class="text-xl font-bold text-white tracking-tight uppercase">{{ $deck->name }}</div>
        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest bg-slate-900 border border-slate-800 px-3 py-1 rounded">
            Card <span id="current-card-idx">0</span> / <span id="total-cards-count">0</span>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="w-full max-w-2xl bg-slate-800 h-2 mb-10 overflow-hidden rounded-full">
        <div class="bg-slate-500 h-2 transition-all duration-500" id="study-progress" style="width: 0%"></div>
    </div>

    <!-- Card Area -->
    <div id="card-area" class="w-full max-w-2xl aspect-[3/2] perspective-1000 hidden">
        <div class="flip-card w-full h-full cursor-pointer relative" id="flashcard">
            <div class="flip-card-inner w-full h-full relative shadow-md">
                <!-- Front -->
                <div class="flip-card-front w-full h-full absolute bg-slate-900 border border-slate-700 p-8 flex flex-col items-center justify-center text-center rounded">
                    <span class="absolute top-4 left-4 text-xs font-bold text-slate-500 uppercase tracking-widest"><i class="fa-solid fa-question-circle mr-1"></i> Pergunta</span>
                    <div class="text-3xl font-bold text-white break-all w-full px-4" id="card-front-text"></div>
                    <div class="text-sm text-slate-400 mt-6 hidden font-medium" id="card-hint">Dica: <span></span></div>
                    
                    <div class="absolute bottom-6 text-slate-500 text-xs font-bold uppercase tracking-widest">
                        Clique para revelar
                    </div>
                </div>
                <!-- Back -->
                <div class="flip-card-back w-full h-full absolute bg-slate-800 border border-slate-600 p-8 flex flex-col items-center justify-center text-center rounded">
                    <span class="absolute top-4 right-4 text-xs font-bold text-slate-400 uppercase tracking-widest"><i class="fa-solid fa-check-circle mr-1"></i> Resposta</span>
                    <hr class="w-16 border-slate-600 mb-6 absolute top-12">
                    <div class="text-2xl font-semibold text-slate-200 break-all w-full px-4" id="card-back-text"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Buttons -->
    <div id="rating-buttons" class="w-full max-w-2xl mt-12 grid grid-cols-4 gap-4 opacity-0 transition-opacity duration-500 pointer-events-none">
        <button onclick="submitAnswer(1)" class="py-4 border border-red-900 bg-slate-900 hover:bg-red-950 text-red-400 font-bold uppercase tracking-widest text-sm transition rounded">
            <div class="text-lg mb-1"><i class="fa-solid fa-xmark"></i></div>
            Errei
        </button>
        <button onclick="submitAnswer(3)" class="py-4 border border-orange-900 bg-slate-900 hover:bg-orange-950 text-orange-400 font-bold uppercase tracking-widest text-sm transition rounded">
            <div class="text-lg mb-1"><i class="fa-solid fa-minus"></i></div>
            Difícil
        </button>
        <button onclick="submitAnswer(4)" class="py-4 border border-blue-900 bg-slate-900 hover:bg-blue-950 text-blue-400 font-bold uppercase tracking-widest text-sm transition rounded">
            <div class="text-lg mb-1"><i class="fa-solid fa-check"></i></div>
            Bom
        </button>
        <button onclick="submitAnswer(5)" class="py-4 border border-green-900 bg-slate-900 hover:bg-green-950 text-green-400 font-bold uppercase tracking-widest text-sm transition rounded">
            <div class="text-lg mb-1"><i class="fa-solid fa-check-double"></i></div>
            Fácil
        </button>
    </div>

    <!-- Finished Screen -->
    <div id="finished-screen" class="hidden flex-col items-center justify-center text-center">
        <div class="text-6xl text-slate-600 mb-6"><i class="fa-solid fa-flag-checkered"></i></div>
        <h2 class="text-3xl font-black text-white mb-4 tracking-tight uppercase">Sessão Concluída</h2>
        <p class="text-lg text-slate-400 mb-8">Todos os cards devidos foram revisados com sucesso.</p>
        <div class="flex gap-4">
            <a href="{{ route('decks.index') }}" class="bg-slate-800 hover:bg-slate-700 text-white px-8 py-3 font-bold text-sm uppercase tracking-widest transition border border-slate-700 rounded">
                Retornar
            </a>
            <button onclick="restartStudy()" class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 font-bold text-sm uppercase tracking-widest transition border border-indigo-500 rounded">
                Estudar Novamente
            </button>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    let cards = [];
    let currentIndex = 0;
    let deckId = {{ $deck->id }};

    $(document).ready(function() {
        $.get(`/study/${deckId}/cards`, function(data) {
            cards = data.cards;
            if (cards.length > 0) {
                $('#total-cards-count').text(cards.length);
                $('#card-area').removeClass('hidden');
                loadCard(0);
            } else {
                showFinished();
            }
        });

        $('#flashcard').click(function() {
            if (!$(this).hasClass('flipped')) {
                $(this).addClass('flipped');
                $('#rating-buttons').removeClass('opacity-0 pointer-events-none');
            }
        });
    });

    function loadCard(index) {
        if (index >= cards.length) {
            showFinished();
            return;
        }

        let card = cards[index];
        
        $('#flashcard').removeClass('flipped');
        $('#rating-buttons').addClass('opacity-0 pointer-events-none');
        
        setTimeout(() => {
            $('#card-front-text').text(card.front);
            $('#card-back-text').text(card.back);
            
            if (card.hint) {
                $('#card-hint').removeClass('hidden').find('span').text(card.hint);
            } else {
                $('#card-hint').addClass('hidden');
            }
            
            $('#current-card-idx').text(index + 1);
            updateProgress();
        }, 300);
    }

    function submitAnswer(rating) {
        let card = cards[currentIndex];
        
        $('#rating-buttons button').prop('disabled', true);

        $.ajax({
            url: `/study/${deckId}/answer`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                card_id: card.id,
                rating: rating
            },
            success: function(response) {
                updateGamificationHeader(response.current_xp, response.level, response.streak);
                
                if (response.xp_earned > 0) {
                    showFloatingXp(response.xp_earned);
                }

                currentIndex++;
                loadCard(currentIndex);
                $('#rating-buttons button').prop('disabled', false);
            },
            error: function(xhr) {
                console.error("AJAX Error:", xhr.responseText);
                alert('Erro ao salvar resposta: ' + (xhr.responseJSON?.message || xhr.statusText));
                $('#rating-buttons button').prop('disabled', false);
            }
        });
    }

    function updateProgress() {
        let percent = (currentIndex / cards.length) * 100;
        $('#study-progress').css('width', `${percent}%`);
    }

    function restartStudy() {
        $('#finished-screen').addClass('hidden').removeClass('flex');
        
        $.get(`/study/${deckId}/cards?force_all=1`, function(data) {
            cards = data.cards;
            currentIndex = 0;
            if (cards.length > 0) {
                $('#total-cards-count').text(cards.length);
                $('#card-area').removeClass('hidden');
                $('.w-full.flex.justify-between').removeClass('hidden');
                $('#study-progress').parent().removeClass('hidden');
                updateProgress();
                loadCard(0);
            } else {
                showFinished();
            }
        });
    }

    function showFinished() {
        $('#card-area').addClass('hidden');
        $('#rating-buttons').addClass('hidden');
        $('.w-full.flex.justify-between').addClass('hidden');
        $('#study-progress').parent().addClass('hidden');
        $('#finished-screen').removeClass('hidden').addClass('flex');
    }

    function showFloatingXp(amount) {
        let el = $(`<div class="fixed text-xl font-black text-slate-300 pointer-events-none z-50 transition-all duration-1000 transform -translate-y-10 opacity-0">+${amount} XP</div>`);
        el.css({
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%) scale(0.5)'
        });
        $('body').append(el);
        
        setTimeout(() => {
            el.css({
                transform: 'translate(-50%, -150%) scale(1.5)',
                opacity: 1
            });
        }, 50);

        setTimeout(() => {
            el.css('opacity', 0);
            setTimeout(() => el.remove(), 1000);
        }, 1500);
    }
</script>
@endpush
