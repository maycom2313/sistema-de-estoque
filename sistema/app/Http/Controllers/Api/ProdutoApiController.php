<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rulesuse\Unique;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class ProdutoApiController extends Controller
{
    protected $produto;
    public function __construct(Produto $produto)
    {
        $this->produto = $produto;
    }

    public function index()
    {
        return response()->json($this->produto->all());
    }


    public function store(Request $request)
    {
        $dataForm = $request->all();
        $id = $dataForm['category_id'];
        $category = Category::find($id);
        $dataForm['category'] = $category->name;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $extension = $request->image->extension();
            $name = uniqid(date('his'));
            $nameFile = "{$name}.{$extension}";
            $upload = Image::make($dataForm['image'])->resize(177, 236)->save(storage_path("app/public/produtos/{$nameFile}", 70));

            if (!$upload) {
                return response()->json(['error:' => 'erro no servidor ao salvar imagem'], 500);
            } else {
                $dataForm['image'] = $nameFile;
            }
        }
        $datas = $this->produto->create($dataForm);
        return response()->json($datas);
    }


    public function show($id)
    {
        if (!$data = $this->produto->find($id)) {
            return response()->json(['error:' => 'nenhum produto foi encontrado'], 404);
        }
        return response()->json($data, 200);
    }


    public function update(Request $request, $id)
    {
        if (!$data = $this->produto->find($id)) {
            return response()->json(['error:' => 'nenhum produto foi encontrado'], 404);
        }
        $dataForm = $request->all();
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($data->image) {
                Storage::disk('public')->delete("/produtos/{$data->image}");
            }
            $extension = $request->image->extension();
            $name = uniqid(date('his'));
            $nameFile = "{$name}.{$extension}";
            $upload = Image::make($dataForm['image'])->resize(177, 236)->save(storage_path("app/public/produtos/{$nameFile}", 70));

            if (!$upload) {
                return response()->json(['error:' => 'erro no servidor ao salvar imagem'], 500);
            } else {
                $dataForm['image'] = $nameFile;
            }
        }
        if (!$data->update($dataForm)) {
            return response()->json(['error:' => 'erro no servidor, nao foi possivel atualizar os dados'], 500);
        }
        return response()->json($data);
    }


    public function destroy($id)
    {
        if (!$data = $this->produto->find($id)) {
            return response()->json(['error:' => 'nenhum produto foi encontrado'], 404);
        }
        if ($data->image) {
            Storage::disk('public')->delete("/produtos/{$data->image}");
        }
        $data->delete();
        return response()->json(['sucessful' => 'deletado com sucesso'], 200);
    }

    public function filtro(Request $request)
    {
        $datas = $request->all();
        if (!$datas['category'] && !$datas['sexo']) {
            return response()->json(['error' => 'não foi enviado nada para filtrar']);
        }
        if ($datas['category'] && !$datas['sexo']) {
            $id = $datas['category'];
            $category = Category::find($id);
            $produtoFilter = $category->with('produtos')->find($id);
            return response()->json($produtoFilter);
        } else if ($datas['sexo'] && !$datas['category']) {
            $sexo = $datas['sexo'];
            $produtoFilter = $this->produto->where('sexo', $sexo)->get();
            return response()->json($produtoFilter);
        } else if ($datas['sexo'] && $datas['category']) {
            $id = $datas['category'];
            $sexo = $datas['sexo'];

            $category = Category::find($id);
            $name = $category->name;

            $produtoFilter = $this->produto->where([['sexo', $sexo], ['category', $name]])->get();
            return response()->json($produtoFilter);
        }
    }

   /*  public function category($id)
    {
        if (!$data = Category::find($id)) {
            return response()->json(['error' => 'categoria nao encontrada'], 404);
        }
        $cProdutos = $data->with('produtos')->find($id);
        //var_dump($cProdutos);
        return response()->json($cProdutos);
    } */
}
