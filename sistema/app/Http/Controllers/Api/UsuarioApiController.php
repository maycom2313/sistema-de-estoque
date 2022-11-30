<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioApiController extends Controller
{
    protected $usuario;
    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }
    
    public function index()
    {
        $datas = $this->usuario->all();
        return response()->json($datas);
    }

    
    public function store(Request $request)
    {
       $datas = $request->all();
       $datas['api_token'] = Str::random(60);
       $insert = $this->usuario->create($datas);
       //unset($insert['password']);
       return response()->json($insert);
    }

    
    public function show($id)
    {
        if(!$user = $this->usuario->find($id));
        
    }

    
    public function update(Request $request, $id)
    {
        if(!$user = $this->usuario->find($id)){
            return response()->json(['error:' => 'usuario não encontrado'], 404);
        }
        $datas = $request->all();
        unset($datas['password']);
        if(!$update = $user->update($datas)){
            return response()->json(['error:' => 'erro no servidor, não foi possivel atualizar', 500]);
        }
        return response()->json($datas, 200);
    }

    
    public function destroy($id)
    {
        
    }
}
