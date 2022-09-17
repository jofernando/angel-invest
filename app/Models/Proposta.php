<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'video_caminho',
        'thumbnail_caminho',
    ];

    /**
     * Relacionamento inverso para startup
     *
     * @return Startup $startup : startup relacionada a proposta
     */

    public function startup()
    {
        return $this->belongsTo(Startup::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->using(Like::class);
    }

    /**
     * Relacionamento para leilão
     *
     * @return Collect $leioes : Collect de leilões a qual a proposta está relacionada
     */
    public function leiloes()
    {
        return $this->hasMany(Leilao::class);
    }

    /**
     * Retorna o leilão que está acontecendo atualmente
     *
     * @return Leilao $leilao
     */
    public function leilao_atual()
    {
        $hoje = now();
        return $this->leiloes()->where([['data_inicio', '<=', $hoje], ['data_fim', '>=', $hoje]])->first();
    }
}
