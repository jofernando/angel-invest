<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    public function investidor()
    {
        return $this->belongsTo(Investidor::class);
    }

    public function transacaoPagamento() {
        $mensagem = "";

        if($this->status_transacao == 1) {
            $mensagem = "Aguardando pagamento";
        }
        else if($this->status_transacao == 2) {
            $mensagem = "Em análise";
        }
        else if($this->status_transacao == 3) {
            $mensagem = "Paga";
        }
        else if($this->status_transacao == 4) {
            $mensagem = "Disponível";
        }
        else if($this->status_transacao == 5) {
            $mensagem = "Em disputa";
        }
        else if($this->status_transacao == 6) {
            $mensagem = "Devolvida";
        }
        else if($this->status_transacao == 7) {
            $mensagem = "Cancelada";
        }

        return $mensagem;
    }
}
