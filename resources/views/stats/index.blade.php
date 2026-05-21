@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="max-w-7xl mx-auto space-y-8">
    <div class="bg-slate-900 border border-slate-800 p-6 rounded shadow-sm">
        <h2 class="text-2xl font-bold text-white tracking-tight uppercase">Estatísticas do FlashQuest</h2>
        <p class="text-slate-400 mt-2">Visão geral do seu progresso e métricas de retenção baseadas no algoritmo de espaçamento.</p>
    </div>

    <!-- Basic Overview -->
    <div>
        <h3 class="font-black text-white uppercase tracking-widest text-sm mb-4"><i class="fa-solid fa-bolt text-amber-500 mr-2"></i> Resumo Básico</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-slate-800 border border-slate-700 p-6 rounded text-center hover:border-slate-600 transition">
                <div class="text-3xl font-black text-white">{{ auth()->user()->stats->level ?? 1 }}</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Nível</div>
            </div>
            <div class="bg-slate-800 border border-slate-700 p-6 rounded text-center hover:border-slate-600 transition">
                <div class="text-3xl font-black text-white">{{ auth()->user()->stats->streak_days ?? 0 }}</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Dias de Ofensiva</div>
            </div>
            <div class="bg-slate-800 border border-slate-700 p-6 rounded text-center hover:border-slate-600 transition">
                <div class="text-3xl font-black text-white">{{ array_sum($cardCounts) }}</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Cartões no Sistema</div>
            </div>
            <div class="bg-slate-800 border border-slate-700 p-6 rounded text-center hover:border-slate-600 transition">
                <div class="text-3xl font-black text-white">{{ auth()->user()->stats->cards_reviewed_total ?? 0 }}</div>
                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Total de Revisões</div>
            </div>
        </div>
    </div>

    <!-- Advanced Analysis -->
    <div>
        <h3 class="font-black text-white uppercase tracking-widest text-sm mb-4 mt-8"><i class="fa-solid fa-chart-area text-indigo-500 mr-2"></i> Análise Avançada</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Forecast -->
            <div class="bg-slate-900 border border-slate-800 p-6 rounded shadow-sm">
                <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Previsão (Próximos 30 dias)</h4>
                <div id="chartForecast"></div>
            </div>

            <!-- Review History -->
            <div class="bg-slate-900 border border-slate-800 p-6 rounded shadow-sm">
                <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Histórico de Revisões (Últimos 14 dias)</h4>
                <div id="chartHistory"></div>
            </div>

            <!-- Card Counts Pie -->
            <div class="bg-slate-900 border border-slate-800 p-6 rounded shadow-sm">
                <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Maturidade do Baralho</h4>
                <div id="chartMaturity"></div>
            </div>

            <!-- Buttons Used -->
            <div class="bg-slate-900 border border-slate-800 p-6 rounded shadow-sm">
                <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Botões de Resposta</h4>
                <div id="chartButtons"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const darkThemeOptions = {
        chart: {
            foreColor: '#94a3b8',
            toolbar: { show: false },
            fontFamily: 'inherit'
        },
        tooltip: {
            theme: 'dark'
        },
        grid: {
            borderColor: '#334155',
            strokeDashArray: 4,
        }
    };

    // 1. Forecast Chart
    var forecastOptions = {
        ...darkThemeOptions,
        series: [{
            name: 'Revisões Agendadas',
            data: {!! json_encode($futureDue['counts']) !!}
        }],
        chart: {
            type: 'bar',
            height: 300,
            foreColor: '#94a3b8',
            toolbar: { show: false }
        },
        colors: ['#3b82f6'],
        xaxis: {
            categories: {!! json_encode($futureDue['dates']) !!},
            labels: { show: false }
        },
        dataLabels: { enabled: false }
    };
    new ApexCharts(document.querySelector("#chartForecast"), forecastOptions).render();

    // 2. History Chart
    var historyOptions = {
        ...darkThemeOptions,
        series: [{
            name: 'Revisões Concluídas',
            data: {!! json_encode($history['counts']) !!}
        }],
        chart: {
            type: 'area',
            height: 300,
            foreColor: '#94a3b8',
            toolbar: { show: false }
        },
        colors: ['#10b981'],
        fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.1, stops: [0, 90, 100] }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: {
            categories: {!! json_encode($history['dates']) !!},
            labels: { show: false }
        }
    };
    new ApexCharts(document.querySelector("#chartHistory"), historyOptions).render();

    // 3. Maturity Pie Chart
    var maturityOptions = {
        ...darkThemeOptions,
        series: {!! json_encode($cardCounts) !!},
        chart: { type: 'donut', height: 300 },
        labels: ['Maduras (>21d)', 'Jovens (<21d)', 'Aprendizado'],
        colors: ['#10b981', '#3b82f6', '#f59e0b'],
        stroke: { show: false },
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: { size: '75%', labels: { show: true, name: { color: '#94a3b8' }, value: { color: '#fff' } } }
            }
        }
    };
    new ApexCharts(document.querySelector("#chartMaturity"), maturityOptions).render();

    // 4. Buttons Chart
    var buttonsOptions = {
        ...darkThemeOptions,
        series: [{
            name: 'Vezes Pressionado',
            data: [{{ $buttons['Errei'] }}, {{ $buttons['Difícil'] }}, {{ $buttons['Bom'] }}, {{ $buttons['Fácil'] }}]
        }],
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        labels: ['Errei', 'Difícil', 'Bom', 'Fácil'],
        colors: ['#ef4444', '#f59e0b', '#3b82f6', '#10b981'],
        plotOptions: { bar: { distributed: true, borderRadius: 4 } },
        dataLabels: { enabled: true, style: { colors: ['#fff'] } },
        legend: { show: false }
    };
    new ApexCharts(document.querySelector("#chartButtons"), buttonsOptions).render();

</script>
@endsection
