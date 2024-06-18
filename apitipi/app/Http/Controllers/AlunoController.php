<?php

namespace App\Http\Controllers;


use App\Models\Usuario;
use App\Models\Aluno;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlunoController extends Controller
{

    public $aluno;


    public function __construct(Aluno $aluno)
    {
        $this->aluno = $aluno;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $aluno = Aluno::all();
        $alunos = $this->aluno->all();

        return response()->json($alunos, 200);

    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        $usuario = Usuario::where('email', $credentials['email'])->where('senha', $credentials['senha'])->first();

        if ($usuario && $usuario->tipo_usuario_type === 'aluno') {
            $aluno = $usuario->tipo_usuario()->first();
            if ($aluno) {

                $token = $usuario->createToken('Token de Acesso')->plainTextToken;

                return response()->json([
                    'message' => 'Login bem sucedido!',
                    'usuario' => [
                        'id'    => $usuario->id,
                        'nome'  => $usuario->nome,
                        'email' => $usuario->email,
                        'tipo_usuario'  => $usuario->tipo_usuario_type,
                        'dados_aluno'   => [
                            'idAluno'   => $aluno->id,
                            'nome'      => $aluno->nome,
                        ],
                    ],

                    'acess_token' => $token,
                    'token_type'  => 'Bearer',
                ]);
            }
        }
        return response()->json(['message' => 'Credenciais inválidas ou usuário não é aluno'], 401);
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate($this->aluno->Regras(),$this->aluno->Feedback());

        $imagem = $request->file('foto');

        $imagem_url = $imagem->store('imagem', 'public'); // guarda o caminho


        $alunos = $this->aluno->create([
            'nome' => $request->nome,
            'foto' => $imagem_url
        ]);

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

       $alunos = $this->aluno->find($id);


        if($alunos === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O aluno não existe!'], 404);
        }

        if($request->method() === 'PATCH'){

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

        if($request->file('foto')){
            Storage::disk('public')->delete($alunos->foto);
        }

        $imagem = $request->file('foto');
        $imagem_url = $imagem->store('imagem', 'public'); //

        $alunos->update([
            'nome' => $request->nome,
            'foto' => $imagem_url
        ]);

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

        Storage::disk('public')->delete($alunos->foto);

        $alunos->delete();

        return [['msg' => 'O registro foi removido com sucesso.'], 200];
    }
}
