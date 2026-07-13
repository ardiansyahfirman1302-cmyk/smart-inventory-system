<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_no', 'product_id', 'user_id', 'title', 'description',
        'status', 'priority', 'cost', 'scheduled_at', 'completed_at',
    ];

    protected $casts = [
        'scheduled_at' => 'date',
        'completed_at' => 'date',
        'cost' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
