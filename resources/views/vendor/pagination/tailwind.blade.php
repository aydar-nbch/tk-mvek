@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between py-3">

    <div class="flex gap-2 items-center justify-between w-full sm:hidden">
        @if ($paginator->onFirstPage())
        <span
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed leading-5 rounded-lg dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
            Назад
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 leading-5 rounded-lg hover:text-amber-600 hover:bg-amber-50 hover:border-amber-300 focus:outline-none focus:ring ring-amber-300 active:bg-amber-100 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
            Назад
        </a>
        @endif

        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 leading-5 rounded-lg hover:text-amber-600 hover:bg-amber-50 hover:border-amber-300 focus:outline-none focus:ring ring-amber-300 active:bg-amber-100 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200">
            Вперед
        </a>
        @else
        <span
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed leading-5 rounded-lg dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
            Вперед
        </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">

        <div>
            <p class="text-sm text-slate-600 leading-5">
                Показано с
                @if ($paginator->firstItem())
                <span class="font-bold px-0.5" style="color: #0f172a !important; background: transparent !important;">{{
                    $paginator->firstItem() }}</span>
                по
                <span class="font-bold px-0.5" style="color: #0f172a !important; background: transparent !important;">{{
                    $paginator->lastItem() }}</span>
                @else
                <span class="font-bold px-0.5" style="color: #0f172a !important; background: transparent !important;">{{
                    $paginator->count() }}</span>
                @endif
                из
                <span class="font-bold px-0.5" style="color: #0f172a !important; background: transparent !important;">{{
                    $paginator->total() }}</span>
                результатов
            </p>
        </div>

        <div>
            <span
                class="inline-flex shadow-sm rounded-lg border border-slate-200 bg-white divide-x divide-slate-200 overflow-hidden dark:bg-gray-800 dark:border-gray-600 dark:divide-gray-600">

                {{-- Ссылка на предыдущую страницу (Стрелочка влево) --}}
                @if ($paginator->onFirstPage())
                <span aria-disabled="true"
                    class="inline-flex items-center px-3 py-2 text-slate-300 bg-slate-50 cursor-not-allowed dark:bg-gray-700 dark:text-gray-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                    class="inline-flex items-center px-3 py-2 text-slate-500 hover:bg-amber-50 hover:text-amber-600 transition ease-in-out duration-150 dark:text-gray-400 dark:hover:bg-gray-900"
                    aria-label="Предыдущая страница">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                @endif

                {{-- Элементы пагинации (Цифры и троеточия) --}}
                @foreach ($elements as $element)
                {{-- Разделитель "Три точки" --}}
                @if (is_string($element))
                <span aria-disabled="true"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-400 bg-slate-50 cursor-default dark:bg-gray-800 dark:text-gray-500">
                    {{ $element }}
                </span>
                @endif

                {{-- Массив со ссылками на страницы --}}
                @if (is_array($element))
                @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span aria-current="page"
                    class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-amber-500 cursor-default leading-5">
                    {{ $page }}
                </span>
                @else
                <a href="{{ $url }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-600 hover:bg-amber-50 hover:text-amber-600 transition ease-in-out duration-150 dark:text-gray-300 dark:hover:bg-gray-900"
                    aria-label="Перейти на страницу {{ $page }}">
                    {{ $page }}
                </a>
                @endif
                @endforeach
                @endif
                @endforeach

                {{-- Ссылка на следующую страницу (Стрелочка вправо) --}}
                @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                    class="inline-flex items-center px-3 py-2 text-slate-500 hover:bg-amber-50 hover:text-amber-600 transition ease-in-out duration-150 dark:text-gray-400 dark:hover:bg-gray-900"
                    aria-label="Следующая страница">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                @else
                <span aria-disabled="true"
                    class="inline-flex items-center px-3 py-2 text-slate-300 bg-slate-50 cursor-not-allowed dark:bg-gray-700 dark:text-gray-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif