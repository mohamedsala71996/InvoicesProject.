<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'description',
        'sections_id',
        'Created_by',
    ];

    public function sections(): BelongsTo
    {
        return $this->belongsTo(sections::class);
    }
}
