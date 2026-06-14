<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Транспортная компания «МВЕК-Транс»</title>
    <!-- Подключаем Tailwind CSS по CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">

    <!-- Верхнее меню (Шапка) -->
    <nav class="bg-slate-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Логотип -->
                <div class="flex items-center space-x-3">
                    <span class="text-2xl font-black text-amber-500 tracking-wider">МВЕК</span>
                    <span class="text-slate-400 text-sm hidden md:inline">| Транспортная компания</span>
                </div>

                <!-- Кнопки перехода -->
                <div class="flex space-x-4 items-center">
                    <a href="{{ route('welcome') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium hover:text-amber-500 transition">Главная</a>
                    <a href="{{ route('trips.index') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium hover:text-amber-500 transition">Каталог
                        рейсов</a>

                    @auth
                    <!-- Панель для авторизованного диспетчера с выпадающим меню (Dropdown) -->
                    <div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
                        <!-- Кнопка с именем пользователя и стрелочкой -->
                        <button @click="open = !open" type="button"
                            class="inline-flex items-center space-x-2 text-emerald-400 text-xs px-3 py-2 bg-slate-800 rounded-lg border border-emerald-500/20 hover:bg-slate-700 transition focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :class="{'rotate-180': open}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    
                        <!-- Выпадающее меню -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 rounded-xl bg-white border border-slate-200 shadow-lg py-1 z-50"
                            style="display: none;">
                    
                            <span
                                class="block px-4 py-2 text-[10px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                                Управление
                            </span>
                    
                            <a href="{{ route('trips.create') }}"
                                class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-amber-50 hover:text-amber-600 transition font-medium">
                                Добавить рейс
                            </a>
                    
                            <hr class="border-slate-100">
                    
                            <!-- Форма выхода -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition font-medium">
                                    Выйти из аккаунта
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <!-- Гостевая кнопка входа -->
                    <a href="{{ route('login') }}"
                        class="text-slate-300 hover:text-white text-sm font-medium transition bg-slate-800 px-4 py-2 rounded-lg">
                        Вход (Диспетчер)
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Главная контентная область -->
    <main class="flex-grow py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Flash-сообщения (Всплывающие уведомления) -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-400 text-emerald-800 rounded-lg shadow-sm flex items-center space-x-2"
                id="flash-banner">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Подвал сайта -->
    <footer class="bg-slate-900 text-slate-500 py-6 border-t border-slate-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs">
            <p>&copy; 2026 АНПОО «Международный Восточно-Европейский Колледж». Все права защищены.</p>
            <p class="mt-1">Разработано в рамках курсовой работы по профессиональному модулю ПМ.09</p>
            <p class="mt-1">студентом группы ЭдИС-242/2 Ситдиковым Айдаром</p>
        </div>
    </footer>

</body>

</html>