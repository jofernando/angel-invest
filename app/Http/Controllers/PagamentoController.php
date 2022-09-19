<?php

namespace App\Http\Controllers;
use PagSeguro;
use App\Http\Requests\PagamentoRequest;
use App\Models\Investidor;
use App\Models\Pagamento;
use Carbon\Carbon;
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

    public function dashboard($ordenacao) {
        $this->authorize('isAdmin', User::class);
        switch ($ordenacao) {
            case '7_dias':
                $collection = Pagamento::where('created_at', '>=', Carbon::now()->subWeek())
                ->selectRaw("
                sum(valor) AS sum,
                extract(DAY FROM created_at) AS day
                ")
                ->orderBy('day')
                ->groupBy('day')

                ->get();

                $pagamentos = $collection->toArray();
                $pagamentos = array_reduce($pagamentos, function ($result, $item) {
                    $result[$item['day']] = $item['sum'];
                    return $result;
                }, array());
                break;
            case 'ultimo_mes':
                $collection =  Pagamento::where('created_at', '>=', Carbon::now()->subMonth())
                ->selectRaw("
                sum(valor) AS sum,
                extract(DAY FROM created_at) AS day
                ")
                ->orderBy('day')
                ->groupBy('day')
                ->get();

                $pagamentos = $collection->toArray();
                $pagamentos = array_reduce($pagamentos, function ($result, $item) {
                    $result[$item['day']] = $item['sum'];
                    return $result;
                }, array());
                break;
            case 'meses':
                $collection =  Pagamento::where('created_at', '>=', Carbon::now()->subYear())
                ->selectRaw("
                sum(valor) AS sum,
                extract(MONTH FROM created_at) AS month
                ")
                ->orderBy('month')
                ->groupBy('month')
                ->get();

                $pagamentos = $collection->toArray();
                $pagamentos = array_reduce($pagamentos, function ($result, $item) {
                    $result[$item['month']] = $item['sum'];
                    return $result;
                }, array());
                break;
            case 'anos':
                $collection =  Pagamento::where('created_at', '>=', Carbon::now()->subYears(5))
                ->selectRaw("
                sum(valor) AS sum,
                extract(YEAR FROM created_at) AS year
                ")
                ->orderBy('year')
                ->groupBy('year')
                ->get();
                $pagamentos = $collection->toArray();
                $pagamentos = array_reduce($pagamentos, function ($result, $item) {
                    $result[$item['year']] = $item['sum'];
                    return $result;
                }, array());
                break;
            default:
                $collection = Pagamento::where('created_at', '>=', Carbon::now()->subWeek())
                ->selectRaw("
                sum(valor) AS sum,
                extract(DAY FROM created_at) AS day
                ")
                ->orderBy('day')
                ->groupBy('day')
                ->get();
                $pagamentos = $collection->toArray();
                $pagamentos = array_reduce($pagamentos, function ($result, $item) {
                    $result[$item['day']] = $item['sum'];
                    return $result;
                }, array());
                break;
        }

        $titulo = $this->titulo($ordenacao);
        return view('admin.dashboard', compact("pagamentos", "collection", "ordenacao", "titulo"));
    }

    private function titulo($ordenacao) {
        switch ($ordenacao) {
            case '7_dias':
                $titulo = "Gráfico de compra de créditos nos últimos 7 dias";
                break;
            case 'ultimo_mes':
                $titulo = "Gráfico de compra de créditos nos últimos 30 dias";
                break;
            case 'meses':
                $titulo = "Gráfico de compra de créditos nos últimos 12 meses";
                break;
            case 'anos':
                $titulo = "Gráfico de compra de créditos nos últimos 5 anos";
                break;
        }
        return $titulo;
    }
}
