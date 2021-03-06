<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Professor;
use App\Http\Requests\AlunoRequest;
use Illuminate\Support\Facades\Auth;

class AlunoController extends Controller
{
    protected $user_id;


    /* pegando o id do usuário logado */

    public function __construct(){
        $this->middleware('auth');

        $this->middleware(function($request,$next){
            $this->user_id = Auth::id();
            return $next($request);
        });
    }


    /*
     retorna a view index com os alunos cadastrados
     */
    public function index()
    {
        $alunos = Aluno::where('user_id',$this->user_id)->with('professor')->paginate(10);
        $profs = Professor::where('user_id',$this->user_id)
        ->where('situacao','ativado')->get();
        return view('aluno.index',['alunos'=>$alunos,'profs'=>$profs]);
    }


    /*
     insere um aluno no banco
     */
    public function store(AlunoRequest $request)
    {
        $data = $request->validated();
        Aluno::create([
            'nome' => $data['nome'],
            'curso' => $data['curso'],
            'id_professor' => $data['sel_professores'],
            'user_id' => $this->user_id,
        ]);
        return redirect()->route('aluno.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /*
     ativa ou desativa o aluno com base na situação atual
     */

    public function changeSituacao($id)
    {
        $aluno = Aluno::find($id);
        if($aluno){
            if($aluno->situacao === 'ativado'){
                $aluno->situacao = 'desativado';
                $aluno->save();
            }
            else if ($aluno->situacao === 'desativado') {
                $aluno->situacao = 'ativado';
                $aluno->save();
            }
          
        }
        return redirect()->route('aluno.index');
    }


    /*
    atualiza um aluno no banco
    */
    public function update(AlunoRequest $request, $id)
    {
        $aluno = Aluno::find($id);
        $data = $request->validated();
        if ($aluno) {
            $aluno->nome = $data['nome'];
            $aluno->curso = $data['curso'];
            $aluno->id_professor = $data['sel_professores'];
            $aluno->save();
        }
        return redirect()->route('aluno.index');
        
    }

    /**
     * Remove um aluno do banco de dados
     */
    public function delete($id)
    {
        $aluno = Aluno::find($id);
        if($aluno){
            $aluno->delete();
        }
        return redirect()->route('aluno.index');
    }
}
