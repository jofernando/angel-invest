<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assinatura extends Model
{
    use HasFactory;

    protected $fillable = ['plano_id', 'user_id', 'vencimento'];

    /**
     * Get the user that owns the Assinatura
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plano that owns the Assinatura
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plano(): BelongsTo
    {
        return $this->belongsTo(Plano::class);
    }
}
