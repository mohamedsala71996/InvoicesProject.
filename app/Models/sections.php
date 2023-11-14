<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class sections extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_name',
        'description',
        'Created_by',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(product::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(invoices::class);
    }
    
}
