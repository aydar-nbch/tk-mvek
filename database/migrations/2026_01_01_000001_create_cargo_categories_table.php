<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Создание таблицы категорий.
     */
    public function up(): void
    {
        Schema::create('cargo_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название (например, "Международные автоперевозки")
            $table->text('description')->nullable(); // Краткое описание особенностей
            $table->timestamps();
        });
    }

    /**
     * Откат миграции.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo_categories');
    }
};
