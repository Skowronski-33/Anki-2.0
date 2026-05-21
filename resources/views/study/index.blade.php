@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto h-full flex flex-col items-center justify-center py-10" id="study-container">
    
    <div class="w-full flex justify-between items-center mb-6 px-4">
        <a href="{{ route('decks.index') }}" class="text-slate-500 hover:text-slate-900 font-semibold uppercase text-sm tracking-wide">
            <i class="fa-solid fa-arrow-left mr-2"></i> Abortar Missão
        </a>
        <div class="text-xl font-bold text-slate-900 tracking-tight uppercase">{{ $deck->name }}</div>
        <div class="text-xs font-bold text-slate-500 uppercase tracking-widest bg-white border border-slate-200 px-3 py-1 rounded">
            Card <span id="current-card-idx">0</span> / <span id="total-cards-count">0</span>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="w-full max-w-2xl bg-slate-200 h-2 mb-10 overflow-hidden">
        <div class="bg-slate-900 h-2 transition-all duration-500" id="study-progress" style="width: 0%"></div>
    </div>

    <!-- Card Area -->
    <div id="card-area" class="w-full max-w-2xl aspect-[3/2] perspective-1000 hidden">
        <div class="flip-card w-full h-full cursor-pointer relative" id="flashcard">
            <div class="flip-card-inner w-full h-full relative shadow-md">
                <!-- Front -->
                <div class="flip-card-front w-full h-full absolute bg-white border border-slate-200 p-8 flex flex-col items-center justify-center text-center">
                    <span class="absolute top-4 left-4 text-xs font-bold text-slate-400 uppercase tracking-widest"><i class="fa-solid fa-question-circle mr-1"></i> Pergunta</span>
                    <div class="text-3xl font-bold text-slate-900" id="card-front-text"></div>
                    <div class="text-sm text-slate-500 mt-6 hidden font-medium" id="card-hint">Dica: <span></span></div>
                    
                    <div class="absolute bottom-6 text-slate-400 text-xs font-bold uppercase tracking-widest">
                        Clique para revelar
                    </div>
                </div>
                <!-- Back -->
                <div class="flip-card-back w-full h-full absolute bg-slate-50 border border-slate-300 p-8 flex flex-col items-center justify-center text-center">
                    <span class="absolute top-4 right-4 text-xs font-bold text-slate-400 uppercase tracking-widest"><i class="fa-solid fa-check-circle mr-1"></i> Resposta</span>
                    <hr class="w-16 border-slate-300 mb-6 absolute top-12">
                    <div class="text-2xl font-semibold text-slate-800" id="card-back-text"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Buttons -->
    <div id="rating-buttons" class="w-full max-w-2xl mt-12 grid grid-cols-4 gap-4 opacity-0 transition-opacity duration-500 pointer-events-none">
        <button onclick="submitAnswer(1)" class="py-4 border border-red-200 bg-white hover:bg-red-50 text-red-700 font-bold uppercase tracking-widest text-sm transition">
            <div class="text-lg mb-1"><i class="fa-solid fa-xmark"></i></div>
            Errei
        </button>
        <button onclick="submitAnswer(3)" class="py-4 border border-orange-200 bg-white hover:bg-orange-50 text-orange-700 font-bold uppercase tracking-widest text-sm transition">
            <div class="text-lg mb-1"><i class="fa-solid fa-minus"></i></div>
            Difícil
        </button>
        <button onclick="submitAnswer(4)" class="py-4 border border-blue-200 bg-white hover:bg-blue-50 text-blue-700 font-bold uppercase tracking-widest text-sm transition">
            <div class="text-lg mb-1"><i class="fa-solid fa-check"></i></div>
            Bom
        </button>
        <button onclick="submitAnswer(5)" class="py-4 border border-green-200 bg-white hover:bg-green-50 text-green-700 font-bold uppercase tracking-widest text-sm transition">
            <div class="text-lg mb-1"><i class="fa-solid fa-check-double"></i></div>
            Fácil
        </button>
    </div>

    <!-- Finished Screen -->
    <div id="finished-screen" class="hidden flex-col items-center justify-center text-center">
        <div class="text-6xl text-slate-300 mb-6"><i class="fa-solid fa-flag-checkered"></i></div>
        <h2 class="text-3xl font-black text-slate-900 mb-4 tracking-tight uppercase">Sessão Concluída</h2>
        <p class="text-lg text-slate-600 mb-8">Todos os cards devidos foram revisados com sucesso.</p>
        <a href="{{ route('decks.index') }}" class="bg-slate-900 hover:bg-slate-800 text-white px-8 py-3 font-bold text-sm uppercase tracking-widest transition">
            Retornar
        </a>
    </div>

</div>

@endsection

@push('scripts')
<script>
    let cards = [];
    let currentIndex = 0;
    let deckId = {{ $deck->id }};

    $(document).ready(function() {
        // Fetch cards
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

        // Flip card logic
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
        
        // Reset state
        $('#flashcard').removeClass('flipped');
        $('#rating-buttons').addClass('opacity-0 pointer-events-none');
        
        // Set content
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
        }, 300); // Wait for unflip animation if there was one
    }

    function submitAnswer(rating) {
        let card = cards[currentIndex];
        
        // Disable buttons temporarily
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
                // Update topbar gamification
                updateGamificationHeader(response.current_xp, response.level, response.streak);
                
                // Show floating XP text
                if (response.xp_earned > 0) {
                    showFloatingXp(response.xp_earned);
                }

                // Next card
                currentIndex++;
                loadCard(currentIndex);
                $('#rating-buttons button').prop('disabled', false);
            },
            error: function() {
                alert('Erro ao salvar resposta. Tente novamente.');
                $('#rating-buttons button').prop('disabled', false);
            }
        });
    }

    function updateProgress() {
        let percent = (currentIndex / cards.length) * 100;
        $('#study-progress').css('width', `${percent}%`);
    }

    function showFinished() {
        $('#card-area').addClass('hidden');
        $('#rating-buttons').addClass('hidden');
        $('.w-full.flex.justify-between').addClass('hidden');
        $('#study-progress').parent().addClass('hidden');
        $('#finished-screen').removeClass('hidden').addClass('flex');
    }

    function showFloatingXp(amount) {
        let el = $(`<div class="fixed text-xl font-black text-slate-800 pointer-events-none z-50 transition-all duration-1000 transform -translate-y-10 opacity-0">+${amount} XP</div>`);
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
