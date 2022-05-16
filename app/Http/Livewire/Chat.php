<?php

namespace App\Http\Livewire;

use App\Models\Mensagem;
use App\Models\User;
use Livewire\Component;

class Chat extends Component
{
    public User $usuarioLogado;
    public User $usuarioChat;
    public $mensagens;
    public $texto;
    public $ultimaLida;
    public $flag = true;

    protected $listeners = ['mensagemLida' => 'mensagemLida', 'desativarRolagem' => 'desativarRolagem'];

    public function desativarRolagem()
    {
        $this->flag = false;
    }
    public function mensagemLida($id)
    {
        $mensagem = $this->mensagens
            ->where('id', $id)
            ->where('destinatario_id', $this->usuarioLogado->id)
            ->where('visualizada', false)
            ->first();
        if($mensagem) {
            $mensagem->update(['visualizada' => true]);
            $this->desativarRolagem();
        }
    }

    public function enviarMensagem()
    {
        if($this->texto)
        {
            Mensagem::create([
                'remetente_id' => $this->usuarioLogado->id,
                'destinatario_id' => $this->usuarioChat->id,
                'conteudo' => $this->texto,
            ]);
            $this->reset('texto');
            $this->dispatchBrowserEvent('scrollToEnd');
        }
    }

    public function mount(User $user)
    {
        $this->usuarioChat = $user;
        $this->usuarioLogado = auth()->user();
        $this->mensagens = Mensagem::where('remetente_id', $this->usuarioLogado->id)
            ->where('destinatario_id', $this->usuarioChat->id)
            ->orWhere('remetente_id', $this->usuarioChat->id)
            ->where('destinatario_id', $this->usuarioLogado->id)
            ->orderBy('created_at')
            ->get();
        $this->ultimaLida = $this->mensagens
            ->where('destinatario_id', $this->usuarioLogado->id)
            ->where('visualizada', false)
            ->first();
    }

    public function render()
    {
        if($this->flag) {
            $this->dispatchBrowserEvent('scrollToMensagem');
        }
        $this->mensagens = Mensagem::where('remetente_id', $this->usuarioLogado->id)
            ->where('destinatario_id', $this->usuarioChat->id)
            ->orWhere('remetente_id', $this->usuarioChat->id)
            ->where('destinatario_id', $this->usuarioLogado->id)
            ->orderBy('created_at')
            ->get();
        return view('livewire.chat');
    }
}
