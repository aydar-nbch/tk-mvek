@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
    <div class="mb-4">
        <a href="{{ route('trips.index') }}"
            class="text-xs font-bold text-slate-400 hover:text-slate-700 transition">&larr; Вернуться к списку</a>
    </div>

    <h1 class="text-2xl font-black text-slate-900 mb-2">Добавить новый рейс в расписание</h1>
    <p class="text-slate-500 text-sm mb-6">Пожалуйста, внимательно заполните данные о рейсе. Все поля формы проходят
        строгую валидацию.</p>

    <!-- Список ошибок, если валидация не пройдена -->
    @if ($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl">
        <h4 class="text-sm font-bold mb-2">Заполните поля корректно:</h4>
        <ul class="list-disc list-inside text-xs space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('trips.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Категория перевозки -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Категория
                перевозки</label>
            <select name="cargo_category_id"
                class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('cargo_category_id')==$category->id ? 'selected' : '' }}>
                    {{ $category->title }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Направления -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Город
                    отправления</label>
                <input type="text" name="departure_city" value="{{ old('departure_city') }}" required
                    placeholder="например, Ижевск"
                    class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Город
                    назначения</label>
                <input type="text" name="arrival_city" value="{{ old('arrival_city') }}" required
                    placeholder="например, Самара"
                    class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
            </div>
        </div>

        <!-- Дата и статус -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Дата выезда</label>
                <input type="date" name="departure_date" value="{{ old('departure_date') }}" required
                    class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Статус рейса</label>
                <select name="status"
                    class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
                    <option value="Запланирован" {{ old('status')=='Запланирован' ? 'selected' : '' }}>Запланирован
                    </option>
                    <option value="В пути" {{ old('status')=='В пути' ? 'selected' : '' }}>В пути</option>
                    <option value="Доставлен" {{ old('status')=='Доставлен' ? 'selected' : '' }}>Доставлен</option>
                    <option value="Отменен" {{ old('status')=='Отменен' ? 'selected' : '' }}>Отменен</option>
                </select>
            </div>
        </div>

        <!-- ФИО Водителя -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">ФИО Водителя</label>
            <input type="text" name="driver_name" value="{{ old('driver_name') }}" required
                placeholder="Козлов Дмитрий Александрович"
                class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
        </div>

        <!-- Тариф (Стоимость) -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Стоимость перевозки (в
                рублях)</label>
            <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" required placeholder="0.00"
                class="w-full px-4 py-3 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
        </div>

        <!-- Кнопки управления -->
        <div class="pt-6 flex justify-end space-x-3">
            <a href="{{ route('trips.index') }}"
                class="px-6 py-3 text-sm bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-semibold transition">
                Отмена
            </a>
            <button type="submit"
                class="px-6 py-3 text-sm bg-amber-500 hover:bg-amber-400 text-slate-950 font-black rounded-xl transition shadow">
                Добавить в расписание
            </button>
        </div>
    </form>
</div>
@endsection