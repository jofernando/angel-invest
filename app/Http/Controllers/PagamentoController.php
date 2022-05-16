<?php

namespace App\Http\Controllers;
use PagSeguro;
use App\Http\Requests\PagamentoRequest;
use App\Models\Investidor;
use App\Models\Pagamento;
use Illuminate\Http\Request;
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");

class PagamentoController extends Controller
{
    public function index() {
        $pagamentos = Pagamento::all();

        return view('pagamento.index', compact("pagamentos"));
    }

    public function store(PagamentoRequest $request) {
        $pagamento = new Pagamento();
        $pagamento->valor = $request->valor;
        $pagamento->status_transacao = 1;
        $pagamento->hash_pagamento = $request->senderHash;
        $pagamento->investidor_id = auth()->user()->investidor->id;
        $pagamento->save();

        $pagseguro = PagSeguro::setReference($pagamento->id)
            ->setSenderInfo([
                'senderName' => auth()->user()->name, //Deve conter nome e sobrenome
                'senderPhone' => $request->telefone, //Código de área enviado junto com o telefone
                'senderEmail' => auth()->user()->email,
                'senderHash' => $pagamento->hash_pagamento,
                'senderCPF' => auth()->user()->cpf //Ou CNPJ se for Pessoa Júridica
            ])
            ->setCreditCardHolder([
                'creditCardHolderBirthDate' => date('d/m/Y', strtotime(auth()->user()->data_de_nascimento)),
            ])
            ->setShippingAddress([
                'shippingAddressStreet' => $request->rua,
                'shippingAddressNumber' => $request->numero,
                'shippingAddressDistrict' => $request->bairro,
                'shippingAddressPostalCode' => $request->cep,
                'shippingAddressCity' => $request->cidade,
                'shippingAddressState' => $request->estado
            ])
            ->setItems([
                [
                    'itemId' => $pagamento->id,
                    'itemDescription' => 'AnjoCoins',
                    'itemAmount' =>  $pagamento->valor, //Valor unitário
                    'itemQuantity' => '1', // Quantidade de itens
                ]
            ])
            ->send([
                'paymentMethod' => 'creditCard',
                'creditCardToken' => $request->token_cartao,
                'installmentQuantity' => '1',
                'installmentValue' => $pagamento->valor,
            ]
        );

        $pagamento->codigo = $pagseguro->code[0]->__toString();
        $pagamento->update();

        return redirect(route('pagamento.index'))->with(['message' => 'Pagamento registrado, aguardando o pagamento para contabilizar os créditos!']);;
    }

    public function create() {

      return view('pagamento.create');
    }

    public function notificacao(Request $request) {

        $pagseguro = PagSeguro::notification($request->notificationCode, $request->notificationType);
        $pagamento = Pagamento::where([['codigo',$pagseguro->code[0]->__toString()],['id',$pagseguro->reference[0]->__toString()]])->first();

        if($pagamento!=null) {
            if($pagseguro->status[0]->__toString() == '3') {
                $investidor = $pagamento->investidor;
                $investidor->carteira += $pagamento->valor;
                $investidor->update();
            }

            $pagamento->status_transacao = $pagseguro->status[0]->__toString();
            $pagamento->update();
        }
    }

}
