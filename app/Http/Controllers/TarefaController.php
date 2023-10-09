<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use App\Exports\TarefasExport;
use Maatwebsite\Excel\Facades\Excel;

class TarefaController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }   

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $tarefas = Tarefa::where('user_id', $user_id)->paginate(1);
        //dd($tarefas);
        return view('tarefa.index', ['tarefas' => $tarefas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->all();
        $dados['user_id'] = auth()->user()->id;
        $tarefa = Tarefa::create($dados);

        $destinatario = auth()->user()->email;
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;
        if($user_id == $tarefa->user_id){
            return view('tarefa.edit', ['tarefa' => $tarefa]);
        }
        return view('acesso-negado');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;

        if($user_id == $tarefa->user_id){
            $tarefa->update($request->all());
            return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
        }

        return view('acesso-negado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;

        if($user_id == $tarefa->user_id){
            $tarefa->delete();
            return redirect()->route('tarefa.index');
        }

        return view('acesso-negado');
    }

    public function exportacao($formato){
        //verificando se o formato recebido via urla
        //é uma extensão válida
        $extensoes = ['xlsx', 'csv', 'pdf'];
        if(in_array($formato, $extensoes)){
            //caso positivo, fazemos o download
            return Excel::download(new TarefasExport, 'tarefas.'.$formato);
        }else{
            //se não for, retorna para a página de tarefas
            return redirect()->route('tarefa.index');
        }
    }
}
