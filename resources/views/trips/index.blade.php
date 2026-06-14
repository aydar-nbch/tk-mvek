@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-black text-slate-900">Информационный реестр рейсов</h1>
        <p class="text-slate-500 text-sm mt-1">Оперативный контроль расписания, водителей и ценообразования.</p>
    </div>
    @auth
    <a href="{{ route('trips.create') }}"
        class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-5 py-3 rounded-xl transition text-sm shadow">
        + Создать новый рейс
    </a>
    @endauth
</div>

<!-- Панель Поиска, Фильтрации по Категории и Статусу -->
<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm mb-8">
    <form action="{{ route('trips.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
        <!-- Текстовый поиск -->
        <div class="flex-grow">
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">Поиск по ключевым словам</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="ФИО водителя, город выезда или прибытия..."
                class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
        </div>

        <!-- Фильтр по категориям -->
        <div class="w-full lg:w-48">
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">Категория</label>
            <select name="category_id"
                class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
                <option value="">Все категории</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id')==$category->id ? 'selected' : '' }}>
                    {{ $category->title }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Фильтр по СТАТУСУ РЕЙСА (Новое!) -->
        <div class="w-full lg:w-48">
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-2">Статус рейса</label>
            <select name="status"
                class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
                <option value="">Все статусы</option>
                <option value="Запланирован" {{ request('status')=='Запланирован' ? 'selected' : '' }}>Запланирован
                </option>
                <option value="В пути" {{ request('status')=='В пути' ? 'selected' : '' }}>В пути</option>
                <option value="Доставлен" {{ request('status')=='Доставлен' ? 'selected' : '' }}>Доставлен</option>
                <option value="Отменен" {{ request('status')=='Отменен' ? 'selected' : '' }}>Отменен</option>
            </select>
        </div>

        <!-- Управляющие кнопки -->
        <div class="flex items-end space-x-2">
            <button type="submit"
                class="bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold px-6 py-3.5 rounded-xl transition shadow">
                Применить
            </button>
            <a href="{{ route('trips.index') }}"
                class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold px-6 py-3.5 rounded-xl transition">
                Сбросить
            </a>
        </div>
    </form>
</div>

<!-- Реестр/Сетка рейсов -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    @forelse($trips as $trip)
    <div
        class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col hover:border-slate-300 hover:shadow-md transition">

        <!-- Шапка карточки -->
        <div class="p-4 bg-slate-900 text-white flex justify-between items-center">
            <span
                class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 bg-amber-500 text-slate-950 rounded-md">
                {{ $trip->category->title }}
            </span>

            @php
            $colors = [
            'Запланирован' => 'bg-blue-50 text-blue-700 border-blue-200',
            'В пути' => 'bg-amber-50 text-amber-700 border-amber-200',
            'Доставлен' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'Отменен' => 'bg-rose-50 text-rose-700 border-rose-200'
            ];
            $colorClass = $colors[$trip->status] ?? 'bg-slate-50 text-slate-700';
            @endphp
            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full border {{ $colorClass }}">
                {{ $trip->status }}
            </span>
        </div>

        <!-- Контентная часть -->
        <div class="p-6 flex-grow">
            <div class="flex items-center justify-between mb-6">
                <div class="text-center">
                    <span
                        class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-1">Откуда</span>
                    <span class="text-lg font-bold text-slate-800">{{ $trip->departure_city }}</span>
                </div>
                <div class="text-amber-500 font-bold text-xl">&rarr;</div>
                <div class="text-center">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-1">Куда</span>
                    <span class="text-lg font-bold text-slate-800">{{ $trip->arrival_city }}</span>
                </div>
            </div>

            <div class="space-y-3 text-sm text-slate-600 border-t border-slate-100 pt-4">
                <div class="flex justify-between">
                    <span class="text-slate-400">Дата отправления:</span>
                    <span class="font-semibold text-slate-800">{{
                        \Carbon\Carbon::parse($trip->departure_date)->format('d.m.Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Водитель:</span>
                    <span class="font-semibold text-slate-800">{{ $trip->driver_name }}</span>
                </div>
                <div class="flex justify-between items-center border-t border-slate-100 pt-3 mt-1">
                    <span class="text-slate-500 font-bold">Стоимость:</span>
                    <span class="text-xl font-black text-slate-900">{{ number_format($trip->price, 2, ',', ' ') }}
                        ₽</span>
                </div>
            </div>
        </div>

        <!-- Нижняя панель действий -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
            <a href="{{ route('trips.show', $trip->id) }}"
                class="text-slate-600 hover:text-slate-900 font-bold text-xs flex items-center space-x-1">
                <span>Подробности</span>
                <span>&rarr;</span>
            </a>

            @auth
            <div class="flex space-x-2">
                <a href="{{ route('trips.edit', $trip->id) }}"
                    class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                    Редактировать
                </a>
                <form action="{{ route('trips.destroy', $trip->id) }}" method="POST"
                    onsubmit="return confirm('Вы действительно хотите удалить этот рейс из базы данных?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-rose-50 text-rose-600 hover:bg-rose-100 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                        Удалить
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-slate-200">
        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-slate-500 font-medium">Ничего не найдено по заданным параметрам.</p>
    </div>
    @endforelse
</div>

<!-- Постраничная навигация -->
<div class="mt-6">
    {{ $trips->appends(request()->query())->links() }}
</div>
@endsection