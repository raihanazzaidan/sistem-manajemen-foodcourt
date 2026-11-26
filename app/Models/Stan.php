<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stan extends Model
{
    protected $fillable = [
        'id_pemilik',
        'nama_stan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pemilik');
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'id_stan');
    }
}