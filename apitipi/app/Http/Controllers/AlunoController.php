<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoController extends Controller
{

    public $aluno;


    public function __construct(Aluno $aluno)
    {
        $this->aluno = $aluno;
    }

    public function index()
    {

        // $aluno = Aluno::all();
        $alunos = $this->aluno->all();

        return response()->json($alunos, 200);

    }


    public function store(Request $request)
    {
        //return 'Cheguei Aqui - STORE'; retorna formato HTML

        // return ['Cheguei Aqui' => 'STORE']; // retorna estrutura formato JSON, para aplicativos



        $request->validate($this->aluno->Regras(),$this->aluno->Feedback());

        $alunos = $this->aluno->create($request->all());

        return response()->json($alunos, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alunos = $this->aluno->find($id);

        if($alunos === null) {
            return response()->json(['error' => 'Não existe dados para esse aluno'], 404); // a URL é válida, mas o recurso que uqer acessar não existe no banco
        }

        // return 'Cheguei Aqui - SHOW';
        return response()->json($alunos, 200) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    // public function edit(Aluno $aluno)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       //return 'Cheguei aqui - UPDATE';

       /*
        print_r($request->all()); // Novos dados
        echo '<hr>';
        print_r($aluno->getAttributes()); // Dados antigos
        */
       $alunos = $this->aluno->find($id);

        if($alunos === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O aluno não existe!'], 404);
        }

        if($request->method() === 'PATCH'){

            // return ['teste' => 'PATCH'];

            $dadosDinamico = [];

            foreach($alunos->Regras() as $input => $regra){

                if(array_key_exists($input, $request->all())){
                    $dadosDinamico[$input] = $regra;
                }

            }

            // dd($dadosDinamico);

            $request->validate($dadosDinamico, $this->aluno->Feedback());
         }else{

            $request->validate($this->aluno->Regras(), $this->aluno->Feedback());

        }



       $alunos = $this->aluno->update($request->all()); // update dos novos dados

       return response()->json($alunos, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alunos = $this->aluno->find($id);

        if($alunos === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O aluno não existe!'], 404);
        }

        $alunos->delete();

        return [['msg' => 'O registro foi removido com sucesso.'], 200];
    }
}
