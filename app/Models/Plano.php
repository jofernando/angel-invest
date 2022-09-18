<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Plano extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descricao', 'dias', 'valor'];

    /**
     * Get all of the assinaturas for the Plano
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assinaturas(): HasMany
    {
        return $this->hasMany(Assinatura::class);
    }

    /**
     * Get all of the users for the Plano
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Assinatura::class);
    }

    public function assinaturasAtivasDoUsuarioLogado(): HasMany
    {
        return $this->assinaturas()->where('user_id', auth()->user()->id)->where('vencimento', '>=', now());
    }
}
