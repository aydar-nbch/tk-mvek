<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Создание таблицы рейсов/грузоперевозок.
     */
    public function up(): void
    {
        Schema::create('cargo_trips', function (Blueprint $table) {
            $table->id();
            // Внешний ключ на таблицу категорий с каскадным удалением
            $table->foreignId('cargo_category_id')
                ->constrained('cargo_categories')
                ->onDelete('cascade');

            $table->string('departure_city'); // Город отправления
            $table->string('arrival_city'); // Город назначения
            $table->date('departure_date'); // Дата выезда
            $table->string('driver_name'); // ФИО назначенного водителя
            $table->decimal('price', 10, 2); // Стоимость выполнения рейса
            $table->enum('status', ['Запланирован', 'В пути', 'Доставлен', 'Отменен'])->default('Запланирован'); // Статус
            $table->timestamps();
        });
    }

    /**
     * Откат миграции.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo_trips');
    }
};
