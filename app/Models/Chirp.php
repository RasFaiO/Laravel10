<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
    ];

    // Le agregamos el tipo de rta a : BelongsTo
    public function user(): BelongsTo{
        // Retornamos a travez de $this pasamos el metodo belongsTo y le pasamos Usser::class, esto quiere decir que el modelo chirp pertenece a un usuario
        return $this->belongsTo(User::class);

    }
}
