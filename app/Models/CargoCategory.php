<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CargoCategory extends Model
{
    use HasFactory;

    // Поля, разрешенные для массового заполнения
    protected $fillable = ['title', 'description'];

    /**
     * Связь: Одна категория содержит много рейсов (hasMany).
     */
    public function trips(): HasMany
    {
        return $this->hasMany(CargoTrip::class, 'cargo_category_id');
    }
}
