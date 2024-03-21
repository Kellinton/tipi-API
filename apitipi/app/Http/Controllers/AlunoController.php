<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return 'Cheguei Aqui - INDEX';

        $aluno = Aluno::all();

        return $aluno;
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
        //return 'Cheguei Aqui - STORE'; retorna formato HTML

        // return ['Cheguei Aqui' => 'STORE']; // retorna estrutura formato JSON, para aplicativos

        //dd($request->all());

        $aluno = Aluno::create($request->all());

        return $aluno;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function show(Aluno $aluno)
    {
        // return 'Cheguei Aqui - SHOW';
        return $aluno; // passar o id como parametro na url para passar os dados de um aluno em específico
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
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aluno $aluno)
    {
       //return 'Cheguei aqui - UPDATE';

       /*
        print_r($request->all()); // Novos dados
        echo '<hr>';
        print_r($aluno->getAttributes()); // Dados antigos
        */

       $aluno->update($request->all()); // update dos novos dados
       return $aluno;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aluno  $aluno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aluno $aluno)
    {
        //return 'Cheguei aqui - DESTROY';
        $aluno->delete();

        return ['msg' => 'O registro foi removido com sucesso.'];
    }
}
