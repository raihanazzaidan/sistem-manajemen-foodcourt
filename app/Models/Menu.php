<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $fillable = [
        'id_stan',
        'nama_menu',
        'harga',
        'stok',
        'kategori',
        'foto',
    ];

    public function stan(): BelongsTo
    {
        return $this->belongsTo(Stan::class, 'id_stan');
    }
}