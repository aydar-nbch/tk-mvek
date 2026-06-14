<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CargoTrip extends Model
{
    use HasFactory;

    // Поля, разрешенные для изменения через формы (CRUD)
    protected $fillable = [
        'cargo_category_id',
        'departure_city',
        'arrival_city',
        'departure_date',
        'driver_name',
        'price',
        'status'
    ];

    /**
     * Связь: Каждый рейс принадлежит одной конкретной категории (belongsTo).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CargoCategory::class, 'cargo_category_id');
    }
}
