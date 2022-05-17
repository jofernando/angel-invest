<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Mensagem extends Pivot
{
    protected $fillable = ['conteudo', 'visualizada', 'remetente_id', 'destinatario_id'];

    public function remetente()
    {
        return $this->belongsTo(User::class, 'remetente_id');
    }

    public function destinatario()
    {
        return $this->belongsTo(User::class, 'destinatario_id');
    }

    public function dataHelper()
    {
        $ultima = now()->diff(new Carbon($this->created_at));
        if ($ultima->d >= 1) {
            return (new Carbon($this->created_at))->format('d/m/Y');
        } else {
            return (new Carbon($this->created_at))->format('H:i');
        }
    }
}
