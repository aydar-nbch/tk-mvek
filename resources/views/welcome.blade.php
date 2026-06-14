@extends('layouts.app')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
    <div class="p-8 md:p-12 text-center max-w-4xl mx-auto">
        <span
            class="text-xs font-bold text-amber-500 uppercase tracking-widest bg-amber-50 px-3 py-1 rounded-full">Добро
            пожаловать</span>
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight mt-4 mb-4">
            Транспортная компания <br><br><span class="text-amber-500">«МВЕК-Транс»</span>
        </h1>
        <p class="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            Обеспечиваем надежное планирование, диспетчеризацию и осуществление грузовых автомобильных перевозок по всей
            территории страны.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('trips.index') }}"
                class="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-8 py-4 rounded-xl shadow transition text-center">
                Открыть каталог рейсов
            </a>
            @guest
            <a href="{{ route('login') }}"
                class="bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold px-8 py-4 rounded-xl shadow-sm transition text-center">
                Войти как диспетчер
            </a>
            @endguest
        </div>
    </div>
</div>

<!-- Статистика предприятия -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
        <div class="p-3 bg-slate-100 text-slate-800 rounded-xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0">
                </path>
            </svg>
        </div>
        <div>
            <div class="text-3xl font-black text-slate-900">{{ $stats['trips_count'] }}</div>
            <div class="text-slate-500 text-sm font-medium">Всего рейсов в базе данных</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <div class="text-3xl font-black text-amber-500">{{ $stats['active_drivers'] }}</div>
            <div class="text-slate-500 text-sm font-medium">Активных рейсов в пути</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center space-x-4">
        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <div>
            <div class="text-3xl font-black text-emerald-600">{{ $stats['completed_trips'] }}</div>
            <div class="text-slate-500 text-sm font-medium">Успешно доставленных грузов</div>
        </div>
    </div>
</div>
@endsection



