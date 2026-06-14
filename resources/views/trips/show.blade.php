@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('trips.index') }}"
            class="text-sm font-semibold text-slate-500 hover:text-slate-900 transition">
            &larr; Назад к общему списку
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Шапка -->
        <div class="p-6 bg-slate-900 text-white flex justify-between items-center">
            <div>
                <span
                    class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 bg-amber-500 text-slate-950 rounded-md">
                    {{ $cargoTrip->category->title }}
                </span>
                <h1 class="text-2xl font-black mt-2">Рейс #{{ $cargoTrip->id }}</h1>
            </div>

            <span class="text-sm font-semibold px-4 py-1.5 rounded-full bg-slate-800 border border-slate-700">
                {{ $cargoTrip->status }}
            </span>
        </div>

        <!-- Содержимое -->
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-slate-100 pb-8 mb-8">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Маршрут следования</h3>
                    <div class="flex items-center space-x-4">
                        <div class="text-center bg-slate-50 p-4 rounded-xl flex-grow">
                            <span class="text-[10px] text-slate-400 font-medium uppercase">Откуда</span>
                            <span class="text-lg font-bold block text-slate-800">{{ $cargoTrip->departure_city }}</span>
                        </div>
                        <div class="text-slate-400 font-bold">&rarr;</div>
                        <div class="text-center bg-slate-50 p-4 rounded-xl flex-grow">
                            <span class="text-[10px] text-slate-400 font-medium uppercase">Куда</span>
                            <span class="text-lg font-bold block text-slate-800">{{ $cargoTrip->arrival_city }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Коммерческие параметры
                    </h3>
                    <div class="bg-amber-50/50 p-4 rounded-xl border border-amber-200/50">
                        <span class="text-[10px] text-slate-500 font-medium uppercase">Тариф перевозки</span>
                        <span class="text-2xl font-black block text-slate-950 mt-1">
                            {{ number_format($cargoTrip->price, 2, ',', ' ') }} ₽
                        </span>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">Назначенный Водитель
                        </h4>
                        <p class="text-slate-800 font-semibold text-lg">{{ $cargoTrip->driver_name }}</p>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">Планируемая дата
                            отправления</h4>
                        <p class="text-slate-800 font-semibold text-lg">
                            {{ \Carbon\Carbon::parse($cargoTrip->departure_date)->locale('ru')->translatedFormat('j F Y') }} г.
                        </p>
                    </div>
                </div>

                <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 mt-6">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-2">Особенности категории
                        перевозки</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $cargoTrip->category->description }}</p>
                </div>
            </div>
        </div>

        <!-- Панель управления только для админов/диспетчеров -->
        @auth
        <div class="px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-end space-x-3">
            <a href="{{ route('trips.edit', $cargoTrip->id) }}"
                class="bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition">
                Редактировать сведения
            </a>
            <form action="{{ route('trips.destroy', $cargoTrip->id) }}" method="POST"
                onsubmit="return confirm('Вы уверены, что хотите безвозвратно удалить этот рейс?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl transition">
                    Удалить рейс
                </button>
            </form>
        </div>
        @endauth
    </div>
</div>
@endsection