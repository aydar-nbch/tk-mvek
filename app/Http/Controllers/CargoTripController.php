<?php

namespace App\Http\Controllers;

use App\Models\CargoTrip;
use App\Models\CargoCategory;
use Illuminate\Http\Request;

class CargoTripController extends Controller
{
    /**
     * Главная страница (презентационный лендинг).
     */
    public function welcome()
    {
        $stats = [
            'trips_count' => CargoTrip::count(),
            'active_drivers' => CargoTrip::where('status', 'В пути')->count(),
            'completed_trips' => CargoTrip::where('status', 'Доставлен')->count()
        ];

        // Получаем категории для фильтров/меню
        $categories = CargoCategory::all();

        // Получаем последние 3 рейса для вывода на главной странице
        $trips = CargoTrip::with('category')->latest()->take(3)->get();

        // Передаем все три переменные в представление welcome
        return view('welcome', compact('stats', 'categories', 'trips'));
    }

    /**
     * Вывод списка записей (с поиском, фильтрацией по категории и пагинацией).
     */
    public function index(Request $request)
    {
        // ОПТИМИЗАЦИЯ: подгружаем связь 'category' (Eager Loading) для решения проблемы N+1
        $query = CargoTrip::with('category');

        // 1. Поиск по ключевым словам (город или водитель)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('departure_city', 'like', "%{$search}%")
                    ->orWhere('arrival_city', 'like', "%{$search}%")
                    ->orWhere('driver_name', 'like', "%{$search}%");
            });
        }

        // 2. Фильтрация по категории перевозки
        if ($request->filled('category_id')) {
            $query->where('cargo_category_id', $request->input('category_id'));
        }

        // 3. ФИЛЬТРАЦИЯ ПО СТАТУСУ РЕЙСА (Новое!)
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // 4. Сортировка по умолчанию (сначала новые даты выезда)
        $query->orderBy('departure_date', 'desc');

        // Пагинация по 6 записей на страницу
        $trips = $query->paginate(6);
        $categories = CargoCategory::all();

        return view('trips.index', compact('trips', 'categories'));
    }

    /**
     * Отображение формы создания.
     */
    public function create()
    {
        $categories = CargoCategory::all();
        return view('trips.create', compact('categories'));
    }

    /**
     * Валидация и сохранение нового рейса в БД.
     */
    public function store(Request $request)
    {
        // Серверная валидация данных (не менее 3 правил)
        $validated = $request->validate([
            'cargo_category_id' => 'required|exists:cargo_categories,id',
            'departure_city' => 'required|string|min:2|max:100',
            'arrival_city' => 'required|string|min:2|max:100',
            'departure_date' => 'required|date',
            'driver_name' => 'required|string|min:5|max:150',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Запланирован,В пути,Доставлен,Отменен'
        ], [
            'departure_city.required' => 'Укажите город отправления.',
            'departure_city.min' => 'Пункт отправления должен содержать минимум 2 буквы.',
            'arrival_city.required' => 'Укажите город назначения.',
            'driver_name.required' => 'Введите ФИО назначенного водителя.',
            'driver_name.min' => 'ФИО водителя должно быть полным (минимум 5 символов).',
            'price.required' => 'Укажите стоимость грузоперевозки.',
            'price.numeric' => 'Стоимость должна быть числовым значением.'
        ]);

        CargoTrip::create($validated);

        return redirect()->route('trips.index')
            ->with('success', 'Новый рейс успешно добавлен в реестр!');
    }

    /**
     * Детальный просмотр рейса.
     */
    public function show(CargoTrip $cargoTrip)
    {
        $cargoTrip->load('category');
        return view('trips.show', compact('cargoTrip'));
    }

    /**
     * Отображение формы редактирования.
     */
    public function edit(CargoTrip $cargoTrip)
    {
        $categories = CargoCategory::all();
        return view('trips.edit', compact('cargoTrip', 'categories'));
    }

    /**
     * Валидация и обновление данных.
     */
    public function update(Request $request, CargoTrip $cargoTrip)
    {
        $validated = $request->validate([
            'cargo_category_id' => 'required|exists:cargo_categories,id',
            'departure_city' => 'required|string|min:2|max:100',
            'arrival_city' => 'required|string|min:2|max:100',
            'departure_date' => 'required|date',
            'driver_name' => 'required|string|min:5|max:150',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Запланирован,В пути,Доставлен,Отменен'
        ]);

        $cargoTrip->update($validated);

        return redirect()->route('trips.index')
            ->with('success', 'Сведения о рейсе были успешно обновлены!');
    }

    /**
     * Удаление записи.
     */
    public function destroy(CargoTrip $cargoTrip)
    {
        $cargoTrip->delete();

        return redirect()->route('trips.index')
            ->with('success', 'Запись о рейсе успешно удалена из системы.');
    }
}
