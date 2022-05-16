<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $usuarioLogado = auth()->user();
        $usuarios = Mensagem::where('remetente_id', $usuarioLogado->id)
            ->distinct()
            ->with('destinatario')
            ->get()
            ->map(function($msg){
                return $msg->destinatario;
            });
        $usuarios = $usuarios->merge(
            Mensagem::where('destinatario_id', $usuarioLogado->id)
            ->distinct()
            ->with('remetente')
            ->get()
            ->map(function($msg){
                return $msg->remetente;
            })
        );
        $mensagens = collect();
        foreach ($usuarios as $usuario) {
            $mensagens->push(Mensagem::where('remetente_id', $usuarioLogado->id)
                ->where('destinatario_id', $usuario->id)
                ->orWhere('remetente_id', $usuario->id)
                ->where('destinatario_id', $usuarioLogado->id)
                ->orderBy('created_at')
                ->get()->last());
        }
        return view('chat.index', compact('usuarios', 'mensagens'));
    }
}
