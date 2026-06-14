<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CargoCategory;
use App\Models\CargoTrip;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Запуск сидера для заполнения БД.
     */
    public function run(): void
    {
        // 1. Создаем диспетчера для авторизации через Breeze
        User::updateOrCreate(
            ['email' => 'disp@mveu.ru'],
            [
                'name' => 'Диспетчер МВЕК',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Создаем базовые логистические категории
        $categories = [
            [
                'title' => 'Международные автоперевозки',
                'description' => 'Грузоперевозки повышенной сложности между странами СНГ и дальнего зарубежья на тентованных еврофурах.'
            ],
            [
                'title' => 'Рефрижераторные перевозки',
                'description' => 'Перевозка скоропортящихся продуктов питания, химии и медикаментов с жестким поддержанием температурного режима.'
            ],
            [
                'title' => 'Негабаритные грузы',
                'description' => 'Транспортировка строительной и дорожной спецтехники, станков и металлоконструкций на низкорамных тралах.'
            ],
            [
                'title' => 'Сборные грузы (LTL)',
                'description' => 'Экономичная экспресс-доставка небольших партий товаров от разных клиентов в одном направлении.'
            ],
            [
                'title' => 'Прямые перевозки (FTL)',
                'description' => 'Грузоперевозки по территории России на тентованных еврофурах.'
            ]
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[] = CargoCategory::create($cat);
        }

        // 3. Создаем 15 реалистичных рейсов
        $tripsData = [
            ['departure_city' => 'Ижевск', 'arrival_city' => 'Москва', 'driver_name' => 'Иванов Петр Сергеевич', 'price' => 75000.00, 'status' => 'В пути'],
            ['departure_city' => 'Казань', 'arrival_city' => 'Санкт-Петербург', 'driver_name' => 'Сафин Руслан Маратович', 'price' => 95000.00, 'status' => 'Запланирован'],
            ['departure_city' => 'Екатеринбург', 'arrival_city' => 'Ижевск', 'driver_name' => 'Петров Алексей Владимирович', 'price' => 45000.00, 'status' => 'Доставлен'],
            ['departure_city' => 'Москва', 'arrival_city' => 'Новосибирск', 'driver_name' => 'Сидоров Илья Николаевич', 'price' => 180000.00, 'status' => 'Запланирован'],
            ['departure_city' => 'Самара', 'arrival_city' => 'Ижевск', 'driver_name' => 'Хабибуллин Азат Ринатович', 'price' => 38000.00, 'status' => 'Доставлен'],
            ['departure_city' => 'Ижевск', 'arrival_city' => 'Пермь', 'driver_name' => 'Козлов Дмитрий Александрович', 'price' => 25000.00, 'status' => 'В пути'],
            ['departure_city' => 'Нижний Новгород', 'arrival_city' => 'Москва', 'driver_name' => 'Морозов Сергей Павлович', 'price' => 52000.00, 'status' => 'Отменен'],
            ['departure_city' => 'Уфа', 'arrival_city' => 'Челябинск', 'driver_name' => 'Гареев Дамир Наилевич', 'price' => 48000.00, 'status' => 'Доставлен'],
            ['departure_city' => 'Москва', 'arrival_city' => 'Казань', 'driver_name' => 'Федоров Антон Юрьевич', 'price' => 67000.00, 'status' => 'В пути'],
            ['departure_city' => 'Волгоград', 'arrival_city' => 'Краснодар', 'driver_name' => 'Васильев Олег Игоревич', 'price' => 55000.00, 'status' => 'Запланирован'],
            ['departure_city' => 'Ижевск', 'arrival_city' => 'Уфа', 'driver_name' => 'Каримов Рамиль Зуфарович', 'price' => 28000.00, 'status' => 'Доставлен'],
            ['departure_city' => 'Новосибирск', 'arrival_city' => 'Екатеринбург', 'driver_name' => 'Павлов Виктор Семенович', 'price' => 110000.00, 'status' => 'Запланирован'],
            ['departure_city' => 'Ростов-на-Дону', 'arrival_city' => 'Москва', 'driver_name' => 'Смирнов Андрей Петрович', 'price' => 85000.00, 'status' => 'В пути'],
            ['departure_city' => 'Челябинск', 'arrival_city' => 'Самара', 'driver_name' => 'Кузнецов Юрий Михайлович', 'price' => 62000.00, 'status' => 'Доставлен'],
            ['departure_city' => 'Ижевск', 'arrival_city' => 'Казань', 'driver_name' => 'Ахметов Марат Талгатович', 'price' => 22000.00, 'status' => 'Запланирован']
        ];

        foreach ($tripsData as $index => $trip) {
            // Распределяем категории по кругу
            $category = $createdCategories[$index % count($createdCategories)];

            CargoTrip::create([
                'cargo_category_id' => $category->id,
                'departure_city' => $trip['departure_city'],
                'arrival_city' => $trip['arrival_city'],
                'departure_date' => now()->addDays($index - 5)->format('Y-m-d'),
                'driver_name' => $trip['driver_name'],
                'price' => $trip['price'],
                'status' => $trip['status']
            ]);
        }
    }
}
