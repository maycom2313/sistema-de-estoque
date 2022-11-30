<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Produto;

class VendaApiController extends Controller
{
    public function indexVendas(Venda $venda)
    {
        $datas = $venda->all();
        return response()->json($datas);
    }

    public function vendas($id, Venda $venda, Request $request)
    {
        if (!$data = Produto::find($id)) {
            return response()->json(['error:' => 'produto nao foi encontrado'], 404);
        }
        $venda->name = $data->name;
        $venda->size = $data->size;
        $venda->vendidos = $request->vendidos;
        if ($venda->vendidos <= 0) {
            return response()->json(['error' => 'não foi digitado a quantidade de produtos vendidos']);
        }
        if ($venda->vendidos > $data->quantity) {
            return response()->json(['error:' => 'a quantidade de vendas é maior que o numero de produtos']);
        }
        $data->quantity = $data->quantity - $venda->vendidos;
        $venda->quantity = $data->quantity;
        $venda->prici = $data->prici;
        $venda->sexo = $data->sexo;
        $venda->image = $data->image;
        $venda->produto_id = $id;
        $data->save();
        $venda->save();

        return response()->json($venda, 200);
    }
}
