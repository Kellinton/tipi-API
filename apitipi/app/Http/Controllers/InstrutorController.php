<?php

namespace App\Http\Controllers;

use App\Models\Instrutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstrutorController extends Controller
{

    public $instrutor;

    public function __construct(Instrutor $instrutor)
    {
        $this->instrutor = $instrutor;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $instrutores = $this->instrutor->all();

        return response()->json($instrutores, 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate($this->instrutor->Regras(), $this->instrutor->Feedback());

        $imagem = $request->file('foto');

        $imagem_url = $imagem->store('imagem', 'public');

        $instrutores = $this->instrutor->create([
            'nome'  => $request->nome,
            'email' => $request->email,
            'foto'  => $imagem_url
        ]);

        return response()->json($instrutores, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instrutor  $instrutor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $instrutores = $this->instrutor->find($id);

        if($instrutores === null){
            return response()->json(['error' => 'Não existe dados para o instrutor informado.'], 404);
        }

        return response()->json($instrutores, 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instrutor  $instrutor
     * @return \Illuminate\Http\Response
     */
    public function edit(Instrutor $instrutor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instrutor  $instrutor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $instrutores = $this->instrutor->find($id);

        if($instrutores === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O instrutor informado não existe.'], 404);
        }

        if($request->method() === 'PTACH'){

            $dadosDinamico = [];

            foreach($instrutores->Regras() as $input => $regra){

                if(array_key_exists($input, $request->all())){
                    $dadosDinamico[$input] = $regra;
                }
            }

            $request->validate($dadosDinamico, $this->instrutor->Feedback());
        }else{

            $request->validate($this->instrutor->Regras(), $this->instrutor->Feedback());

        }

        if($request->file('foto')){
            Storage::disk('public')->delete($instrutores->foto);
        }

        $imagem = $request->file('foto');
        $imagem_url = $imagem->store('imagem', 'public');

        $instrutores->update([
            'nome'  => $request->nome,
            'email' => $request->email,
            'foto'  => $imagem_url
        ]);



        return response()->json($instrutores, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instrutor  $instrutor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instrutores = $this->instrutor->find($id);

        if($instrutores === null){
            return response()->json(['erro' => 'Instrutor não existe.'], 404);
        }

        Storage::disk('public')->delete($instrutores->foto);

        $instrutores->delete();

        return [['msg' => 'O registro foi removido.'], 200];
    }
}
